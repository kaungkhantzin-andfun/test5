<?php

/**
 * This file is for custom global functions
 * that is needed by multiple components or controllers
 */

namespace App\Helpers;

use App\Jobs\ProcessImage;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Intervention\Image\Facades\Image as InterventionImage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MyHelper
{
	static function storeImage(
		mixed $image,
		array $options = [], // option is array of array
		?bool $queue = true
	): string {
		// prepare unique file name
		$fileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
		$uniqueName = uniqid($fileName . '_') . '.webp';

		$realPath = $image->getRealPath();

		if ($queue) {
			// process image with queue
			ProcessImage::dispatch(
				realPath: $realPath,
				uniqueName: $uniqueName,
				options: $options,
			);
		} else {
			/**
			 * process first image without queue since we need to show ppt thumb
			 * as soon as redirect back to all properties page
			 * then pass isFirst as true
			 */
			self::processStoreImage(
				realPath: $realPath,
				uniqueName: $uniqueName,
				options: $options,
			);
		}

		return $uniqueName;
	}

	static function processStoreImage(
		mixed $realPath,
		string $uniqueName,
		array $options,
	): void {
		// make the image from the path
		$webp = InterventionImage::make($realPath)->encode('webp');

		// backing up to reset back to original image
		$webp->backup();

		if ($options != null && !empty($options)) {
			foreach ($options as $option) {
				self::resizeAndSaveImage(
					img: $webp,
					uniqueName: array_key_exists('namePrefix', $option) ? $option['namePrefix'] . $uniqueName : $uniqueName,
					watermark: array_key_exists('watermark', $option) ? $option['watermark'] : false,
					cropWidth: array_key_exists('cropWidth', $option) ? $option['cropWidth'] : 1500,
					cropHeight: array_key_exists('cropHeight', $option) ? $option['cropHeight'] : null,
				);
			}
		}
	}

	static function resizeAndSaveImage(
		mixed $img,
		string $uniqueName,
		?bool $watermark,
		?int $cropWidth,
		?int $cropHeight,
	): void {
		// reset to original size b4 manipulation
		$img->reset();

		/**
		 * if both width and height are passed, we are expecting the image to be cropped to the exact dimensions
		 * this is usually for the slider & ad images (not property image)
		 */
		if ($cropWidth && $cropHeight) {
			// $img->crop($cropWidth, $cropHeight);
			$img->fit($cropWidth, $cropHeight, function ($constraint) {
				$constraint->upsize();
			});
		} else {
			$img->resize($cropWidth, $cropHeight, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
		}

		if ($watermark) {
			// uploaded image's width
			$width = $img->width();
			if ($width >= 1000) {
				$watermarkWidth = $width / 3;
			} else if ($width <= 300) {
				$watermarkWidth = $width - 20;
			} else {
				$watermarkWidth = 300;
			}

			// Adding watermark to image
			$logo = InterventionImage::make(public_path('assets/images/watermark.png'))->widen(intval($watermarkWidth));

			$img->insert($logo, 'top-right', 50, 50);
		}

		$img->save(storage_path('app/public/') . $uniqueName, 80);
	}

	static function setGlobalSEOData($title, $description, $images = null)
	{
		// setting for all (Google, Facebook, Twitter, JsonLd, ..)
		SEOTools::setTitle($title);
		SEOTools::setDescription($description);

		// hreflang reference is require for both languages in each page
		// Ref: https://moz.com/learn/seo/hreflang-tag
		SEOMeta::addAlternateLanguage('en-us', LaravelLocalization::getLocalizedURL('en'));
		SEOMeta::addAlternateLanguage('my-mm', LaravelLocalization::getLocalizedURL('my'));

		// for og images and twitter images
		SEOTools::setCanonical(url()->current());
		if (!empty($images)) {
			SEOTools::addImages($images);
		} else {
			SEOTools::addImages([config('app.url') . '/assets/images/myanmar-house-og.jpg']);
		}

		// fb app id is require by sharing debugger with the name of "property"
		SEOMeta::addMeta('fb:app_id', '593014221835425', 'property');

		// Facebook OG remaining settings
		$locale = app()->getLocale();
		OpenGraph::addProperty('url', url()->current())
			->addProperty('type', 'website')
			->addProperty('locale', $locale)
			->addProperty('locale:alternate', $locale == 'my' ? 'en' : 'my')
			->setSiteName(__(config('app.name')));

		// Twitter card remaining settings
		TwitterCard::setType('summary_large_image')
			->setUrl(url()->current())
			->setSite(__(config('app.name')));

		// Remaining meta for Json LD
		JsonLd::setType('WebPage')
			->setUrl(url()->current())
			->addValues([
				"@id" => url()->current() . "#webpage",
				"inLanguage" => $locale,
			]);
	}

	static function increaseViewCount(Builder $collection): void
	{

		// if stat is null, set it to 1
		// else increase it by 1
		$collection->update(['stat' => DB::raw('stat + 1')]);
	}

	public static function checkOwner($collection)
	{
		// Check if user is admin or the owner of the property
		if (Auth::user()->role === 'remwdstate20' || Auth::user()->id === $collection->user_id) {
			return true;
		}

		abort(403);
	}
}

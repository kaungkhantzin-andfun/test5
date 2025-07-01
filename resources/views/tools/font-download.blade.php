<x-app-layout>

	<div x-data class="container px-4 mx-auto my-8 space-y-16 xl:px-0 min-h-[calc(100vh-200px)]">
		<section class="prose">
			<header>
				<h1>{{__('Myanmar Fonts')}}</h1>
			</header>

			@if (app()->getLocale() == 'en')

			<p>
				This page is all about <strong>Myanmar fonts</strong>. You can download Myanmar fonts on this page including Zawgyi font, Zawgyi
				keyboard and Myanmar Unicode font. There are lots of Myanmar fonts available for free. One of the most popular fonts was Zawgyi
				font.It was called
				Zawgyi One font. Other popular and free Myanmar unicode fonts are Pyidaungsu Font, Myanmar 3 Font and Myanmar Padauk Font.
			</p>

			@else

			<p>
				ဒီစာမျက်နှာကတော့ မြန်မာဖောင့်နဲ့ဆိုင်တဲ့ ကိစ္စများအတွက်ဖြစ်ပါတယ်။ ဒီစာမျက်နှာမှာ ဇော်ဂျီဖောင့်၊ ဇော်ဂျီကီးဘုတ်နဲ့ မြန်မာ
				ယူနီကုဒ်ဖောင့်တွေကို ဒေါင်းလုဒ်ရယူနိုင်မှာပဲဖြစ်ပါတယ်။ အလကားပေးထားတဲ့ မြန်မာဖောင့်တွေ အများကြီးရှိပါတယ်။ အဲဒီထဲကမှ
				လူသုံးများတာတွေကတော့ ပြည်ထောင်စုဖောင့်၊ ဇော်ဂျီဖောင့် (ဇော်ဂျီဝမ်းဖောင့်)၊ မြန်မာ ၃ ဖောင့် နဲ့ ပိတောက်ဖောင့်တို့ ဖြစ်ပါတယ်။
			</p>

			@endif
		</section>

		<section>
			<h2 class="h2">{{__('Myanmar Font Download')}}</h2>
			<div class="grid gap-6 mt-4 md:grid-cols-2 lg:grid-cols-3">
				<section class="p-4 space-y-2 border rounded border-logo-blue/50 bg-logo-blue/10">
					<h2 class="h3">{{__('Pyidaungsu Font Download')}}</h2>
					<p>{{__('The standard Myanmar unicode font.')}}</p>

					<a class="gap-2 btn max-w-max text-logo-blue hover:underline" href="{{asset('assets/download/Pyidaungsu-1.8.3_Regular.ttf')}}">
						<x-icon.icon path="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
						{{__('PyiDaungSu Font Regular')}}
					</a>
					<a class="gap-2 btn max-w-max text-logo-blue hover:underline" href="{{asset('assets/download/Pyidaungsu-1.8.3_Bold.ttf')}}">
						<x-icon.icon path="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
						{{__('PyiDaungSu Font Bold')}}
					</a>
					<a class="gap-2 btn max-w-max text-logo-blue hover:underline" href="{{asset('assets/download/Pyidaungsu-1.8.3_Numbers.ttf')}}">
						<x-icon.icon path="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
						{{__('PyiDaungSu Font Numbers')}}
					</a>
				</section>
				<section class="p-4 space-y-2 border rounded border-logo-green/50 bg-logo-green/10">
					<h2 class="h3">{{__('Myanmar 3 Font Download')}}</h2>
					<p>{{__("This was the standard Myanmar font for a period of time but Pyidaungsu font is it's successor.")}}</p>

					<a class="gap-2 btn max-w-max text-logo-green hover:underline" href="{{asset('assets/download/Myanmar3_2018.ttf')}}">
						<x-icon.icon path="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
						{{__('Myanmar 3 2018 (Updated Version)')}}
					</a>
					<a class="gap-2 btn max-w-max text-logo-green hover:underline" href="{{asset('assets/download/Myanmar3_MultiOS.ttf')}}">
						<x-icon.icon path="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
						{{__('Myanmar 3 Multi OS (Old Version)')}}
					</a>
				</section>
				<section class="p-4 space-y-2 border rounded border-logo-purple/50 bg-logo-purple/10">
					<h2 class="h3">{{__('Zawgyi Font Download')}}</h2>
					<p>{{__('seo.font.zawgyi-download')}}</p>

					<a class="gap-2 btn max-w-max text-logo-purple hover:underline" href="{{asset('assets/download/Zawgyi-One.ttf')}}">
						<x-icon.icon path="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
						{{__('Zawgyi-One Font')}}
					</a>
				</section>
			</div>
		</section>

		<section class="prose">
			<h2 class="h2">{{__('The evolution of Pyidaungsu Myanmar Unicode font')}}</h2>

			@if (app()->getLocale() == 'en')

			<p>
				Zawgyi One is a non-standard Burmese font but it helped Myanmar internet users for over 10 years with writing and reading on
				the internet. But later on, Myanmar font users and developers noticed some issues.
			</p>

			<p>
				Therefore more Burmese fonts were developed to use on the internet, PC and softwares like photoshop while approaching the unicode
				standard gradually. These fonts include Myanmar 2 Font, Myanmar 3 font, Myanmar Padauk font and much more. <a
					href="/en/tools/myanmar-font-converter">Zawgyi Unicode converter</a> are also developed to convert between non-unicode fonts to
				unicode and unicode fonts to non-unicode.
			</p>

			<p>
				After that, with the help of Myanmar State Counsellor Daw Aung San Suu Kyi, PyiDaungSu font is set as a standard Myanmar unicode font
				to use on the internet and in Government offices. You can download all those Myanmar fonts on this page.
			</p>

			@else

			<p>
				ဇော်ဂျီဖောင့်ကတော့ ယူနီကုဒ်စံတွေနဲ့ သိပ်မကိုက်ခဲ့ပါဘူး ဒါပေမယ့် မြန်မာနိုင်ငံသားတွေ ၁၀ နှစ်ကျော် အဆင်ပြေပြေသုံးလို့ရခဲ့တဲ့ ဖောင့်တစ်ခု
				ဖြစ်ပါတယ်။ ဒါပေမယ့် ရေရှည်မှာ အဆင်မပြေနိုင်မယ့်အကြောင်းလေးတွေ တွေ့လာရတဲ့အတွက် ယူနီကုဒ်စံတွေနဲ့ ပိုကိုက်တဲ့ ဖောင့်တွေကို ထွင်လာကြပါတယ်။
				အဲဒီဖောင့်တွေကတော့ မြန်မာ ၂ ဖောင့်၊ မြန်မာ ၃ ဖောင့်၊ မြန်မာပိတောက်ဖောင့်နဲ့ အခြားအများစွာ ပါပါတယ်။
			</p>

			<p>ဖောင့်တွေ ပြောင်းသုံးလာကြတဲ့အခါ <a href="/tools/myanmar-font-converter">ဇော်ဂျီ ↔ ယူနီကုဒ် မြန်မာဖောင့် ကွန်ဗာတာ</a> တွေကိုလည်း
				ဖောင့်တစ်မျိုးကနေ တစ်မျိုးကို အလွယ်တကူ အပြန်အလှန်ပြောင်းနိုင်ဖို့ တီထွင်လာကြပါတယ်။</p>

			<p>
				အဲဒီနောက်မှာတော့ နိုင်ငံတော်အတိုင်ပင်ခံပုဂ္ဂိုလ် ဒေါ်အောင်ဆန်းစုကြည်က ဦးဆောင်ပြီးတော့ ပြည်ထောင်စုဖောင့်ကို မြန်မာနိုင်ငံသုံး
				စံဖောင့်အဖြစ် သတ်မှတ်ခဲ့ပါတယ်။ အဲဒီနောက်ပိုင်းမှာတော့ ပြည်ထောင်စုဖောင့်ကို အစိုးရရုံးတွေနဲ့ အင်တာနက်ပေါ်မှာနဲ့ အခြားနေရာတွေမှာပါ
				ကျယ်ကျယ်ပြန့်ပြန့် သုံးလာကြပါတယ်။
			</p>

			<p>အဲဒီဖောင့်တွေ အားလုံးကို ဒီစာမျက်နှာမှာ အလွယ်တကူ ဒေါင်းလုဒ်ရယူနိုင်ပါတယ်။</p>

			@endif
		</section>

		<section class="prose">
			<h2 class="h2">{{__('Related Word Counter Tool')}}</h2>

			@if (app()->getLocale() == 'en')

			<p>Someone reached out to us and asked us to mention their tool. We checked it out and thought it could be useful for our users. Here is
				their <a target="_blank" href="https://digitalagencybangkok.com/free-word-counter-character-counter-tool/">word counter</a>, if you
				would like to use it.</p>

			@else

			<p>ဒီတစ်ခုက ကျနော်တို့ဆီကို ဆက်သွယ်လာပြီးတော့ သူတို့ရဲ့ tools လေးပါပြပေးဖို့ ပြောပါတယ်။ ကျနော်တို့ ဝင်စစ်ကြည့်လိုက်တော့လည်း ကျနော်တို့
				user တွေအတွက် အသုံးဝင်မယ်ထင်လို့ သူတို့ရဲ့ <a target="_blank"
					href="https://digitalagencybangkok.com/free-word-counter-character-counter-tool/">ဒီ word counter tool</a> လေးကို
				ဖော်ပြလိုက်ပါတယ်။</p>

			@endif
		</section>

		<section class="prose">
			<h2 class="mt-0 mb-2 font-bold uppercase">{{ __('home.welcome.title') }}</h2>
			<p>@lang('home.welcome.body')</p>
		</section>

	</div>

</x-app-layout>
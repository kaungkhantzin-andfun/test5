<?php

/**
 * This file is just to fix false intelliphense errors
 * ref: https://github.com/bmewburn/vscode-intelephense/issues/2135#issuecomment-1057563880
 */

namespace Illuminate\Contracts\View;

use Illuminate\Contracts\Support\Renderable;

interface View extends Renderable
{
	/** @return static */
	public function layout();
	public function extends();
}

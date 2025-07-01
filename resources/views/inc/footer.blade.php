<footer class="text-white bg-gray-700">
    <div class="container flex flex-col justify-center gap-4 py-4 text-sm lg:items-center lg:justify-between lg:flex-row">
        <div>
            <span>{{ __("Copyright © 2020 - ") . date('Y') . '.'}}</span>
            <span>{{__("All rights reserved by ") }} <a href="{{LaravelLocalization::localizeUrl('/')}}">{{__(config('app.name'))}}</a>.</span>
        </div>

        <nav aria-labelledby="footer-navigation">
            <ul class="flex flex-col gap-1 md:flex-row md:gap-4">
                <li><a href="https://www.myanmarwebdesigner.com/digital-marketing/" target="_blank">Digital Marketing Agency Myanmar</a></li>
                <li><a href="https://digitalagencybangkok.com/mobile-app-development/" target="_blank">Mobile App Company Bangkok</a></li>
                <li><a href="https://www.facebook.com/digitalagencybangkok.DAB/" target="_blank">Digital Marketing Agency Bangkok</a></li>
                <li><a href="https://www.xn----uwf0de8b2blwbbd3fr4aj.com/" target="_blank">ซื้อถุงขยะสีดำ</a></li>
                <li><a href="/blog/1/privacy-policy">Privacy Policy</a></li>
            </ul>
        </nav>
    </div>
</footer>
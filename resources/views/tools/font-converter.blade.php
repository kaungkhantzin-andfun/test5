<x-app-layout>
    <style>
        @font-face {
            font-family: 'Zawgyi-One';
            src: url('/fonts/burmese/Zawgyi-One.woff2') format('woff2'),
                url('/fonts/burmese/Zawgyi-One.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        #unicode {
            font-family: "Pyidaungsu ZawDecode";
            font-size: 16px;
        }

        #zawgyi {
            font-family: "Zawgyi-One";
        }
    </style>

    <x-notices />

    <div x-data class="container px-4 prose mx-auto my-8 xl:px-0 min-h-[calc(100vh-200px)]">
        <header>
            <h1 class="h2">@lang('converter_title')</h1>
        </header>

        <div class="flex flex-col items-center justify-center col-span-2 gap-4 lg:flex-row">
            <div class="flex flex-col w-full" id="Zawgyi">
                <label for="zawgyi" class="font-bold uppercase">{{ __('Zawgyi One') }}</label>
                <textarea x-ref="zawgyi" class="p-3 border rounded shadow min-h-[200px] lg:min-h-[400px]" id="zawgyi"
                    @input="toUni($refs)">ဤဝဘ္ဆိုက္သည္ အခမဲ့ ေၾကာ္ျငာတင္ႏိုင္ေသာ အိမ္ၿခံေျမ ဝဘ္ဆိုက္တစ္ခု ျဖစ္သည္။</textarea>
            </div>

            <x-icon.icon class="w-8 h-8 text-logo-purple lg:transform lg:rotate-90" :add-class="true"
                path="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />

            <div class="flex flex-col w-full" id="Unicode">
                <label for="unicode" class="font-bold uppercase">{{ __('Myanmar Unicode, Pyidaungsu, Myanmar 3') }}</label>
                <textarea x-ref="unicode" class="p-3 border rounded shadow min-h-[200px] lg:min-h-[400px]" id="unicode"
                    @input="toZg($refs)">ဤဝဘ်ဆိုက်သည် အခမဲ့ ကြော်ငြာတင်နိုင်သော အိမ်ခြံမြေ ဝဘ်ဆိုက်တစ်ခု ဖြစ်သည်။</textarea>
            </div>
        </div>

        <div class="sticky flex flex-wrap items-center col-span-2 gap-2 mx-auto my-6 bottom-16 lg:bottom-2 max-w-max">
            <input class="text-sm btn bg-gradient-to-r blue-gradient sm:text-base" type="button" value="{{ __('Copy Zawgyi') }}"
                @click="$clipboard($refs.zawgyi.value); $dispatch('notice', {'type': 'success', 'text': 'Zawgyi text copied!'})">

            <input class="text-sm btn bg-gradient-to-r blue-gradient sm:text-base" type="button" value="{{ __('Copy Unicode') }}"
                @click="$clipboard($refs.unicode.value); $dispatch('notice', {'type': 'success', 'text': 'Unicode text copied!'})">

            <button class="flex items-center gap-1 text-sm btn btn-danger sm:text-base" @click="$refs.unicode.value = $refs.zawgyi.value = ''">
                <x-icon.solid-icon class="hidden sm:block" :add-class="true"
                    path="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" />
                {{ __('Clear') }}
            </button>
        </div>

        <section>
            @if (app()->getLocale() == 'my')
            <h2>ဇော်ဂျီ - ယူနီကုဒ် ကွန်ဗာတာကို ဘယ်လို အသုံးပြုရလဲ?</h2>
            <p>အထက်ပါ အကွက်နှစ်ကွက်ကတော့ အချိန်နဲ့ တပြေးညီ ဖောင့်ပြောင်းပေးတဲ့ မြန်မာဖောင့် ကွန်ဗာတာပဲ ဖြစ်ပါတယ်။
                စာရိုက်ထည့်တာနဲ့ဖြစ်ဖြစ် ဒါမှမဟုတ် ကူးထည့်တာနဲ့ဖြစ်ဖြစ် မြန်မာဖောင့် တစ်ခုကနေ တစ်ခုကို
                ပြောင်းပေးပါတယ်။ မြန်မာ ယူနီကုဒ်ကနေ ပြောင်းချင်တယ်ဆို မြန်မာ ယူနီကုဒ်ဘက်မှာ ရိုက်ထည့်၊
                ကူးထည့်လိုက်တာနဲ့ ဇော်ဂျီဝမ်းဘက်မှာ ဇော်ဂျီဖောင့်ကိုပြောင်းပြီးသား တိုက်ရိုက်ထွက်လာပါမယ်။
                အပြန်အလှန်ပါပဲ၊ ဇော်ဂျီကနေပြောင်းချင်တယ်ဆိုရင် ဇော်ဂျီဝမ်းဘက်မှာ ရိုက်ထည့်၊ ကူးထည့်တာနဲ့ မြန်မာ
                ယူနီကုဒ်ဖောင့်ကို ပြောင်းပြီးသားက မြန်မာ ယူနီကုဒ်အကွက်ထဲမှာ ပေါ်လာမှာဖြစ်ပါတယ်။</p>
            @else
            <h2>How to use Zawgyi to Unicode, Unicode to Zawgyi Converter?</h2>
            <p>The above two fields are the real time <strong>Myanmar font converter</strong>. The converter
                converts from <strong>Zawgyi to Unicode</strong> or from <strong>Unicode to Zawgyi</strong> as you
                type or paste in. If you want to convert from unicode font, just type or paste in at the Myanmar
                unicode side and the <strong>Zawgyi converter</strong> will take action and give you converted
                Zawgyi text on the Zawgyi One side. Vice versa, if you want to convert from Zawgyi font, type or
                paste in at the Zawgyi One side. The <strong>unicode converter</strong> will take action and give
                you converted Unicode text on the Myanmar unicode side.</p>
            @endif
        </section>

        <section>
            @if (app()->getLocale() == 'my')
            <h2>မြန်မာဖောင့် ဒေါင်းလုဒ်</h2>
            <p>
                မြန်မာဖောင့် ကွန်ဗာတာကို အသုံးပြုရတာ ချောမွေ့မယ်လို့ မျှော်လင့်ပါတယ်။ တစ်ကယ်လို သင့်စက်ထဲမှာ အဲဒီဖောင့်တွေ တစ်ခုမှမရှိသေးဘူးဆိုရင်တော့
                <a href="/tools/myanmar-font-download">မြန်မာဖောင့်များ</a> ကို ကျနော်တို့ ဝက်ဘ်ဆိုက်ပေါ်မှာ ဒေါင်းလုဒ် လုပ်နိုင်ပါတယ်။
                ဒီဝက်ဘ်ဆိုက်ပေါ်မှာ ဇော်ဂျီ ဖောင့်၊ ပြည်ထောင်စု ဖောင့်နဲ့ မြန်မာ ၃ ဖောင့်တို့ကို အလွယ်တကူ ဒေါင်းလုဒ် လုပ်နိုင်ပါတယ်။
            </p>
            @else
            <h2>Download Myanmar Fonts</h2>
            <p>
                We hope that the font conversion went well for you. If you don't have any of these fonts you can <a
                    href="/en/tools/myanmar-font-download">download Myanmar fonts</a> on our website. You can download Zawgyi font, Pyidaungsu font,
                Myanmar 3 font and more.
            </p>
            @endif
        </section>

        <section>
            <h2>{{__('Related Word Counter Tool')}}</h2>

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

        <section class="mt-16">
            <h2 class="mt-0 mb-2 font-bold uppercase">{{ __('home.welcome.title') }}</h2>
            <p>@lang('home.welcome.body')</p>
        </section>

        @push('f_scripts')
        <script src="{{ asset('assets/js/cnvrtr.js') }}"></script>
        <script>
            function toZg(refs) {
                    refs.zawgyi.value = House.uni2zg(refs.unicode.value);
                }

                function toUni(refs) {
                    refs.unicode.value = House.zg2uni(refs.zawgyi.value);
                }
        </script>
        @endpush
    </div>

</x-app-layout>
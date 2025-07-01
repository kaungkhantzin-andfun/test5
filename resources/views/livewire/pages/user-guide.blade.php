<div class="pb-10">
    @if (!empty($title))
    <div class="relative mb-6 bg-gray-900 h-28">
        <h1
            class="absolute inset-0 h-16 pt-3 mx-auto my-auto text-4xl font-extrabold text-center text-transparent bg-clip-text bg-gradient-to-b blue-gradient">
            {{ __( $title ) }}</h1>
    </div>
    @endif

    <div class="container mx-auto space-y-8">
        <div class="items-center grid-cols-2 gap-4 space-y-6 lg:space-y-0 lg:grid">
            <div class="space-y-2 leading-7">
                <h4 class="text-lg font-bold">အဆင့် ၁</h4>
                <p>ပထမဦးစွာ "Post Property" သို့မဟုတ် "ကြော်ငြာတင်ရန်" ခလုတ်အားနှိပ်ပါ</p>
            </div>
            <img class="rounded shadow" src="/images/guide/01.webp" alt="">
        </div>

        <div class="items-center grid-cols-2 gap-4 space-y-6 lg:space-y-0 lg:grid">
            <img class="rounded shadow" src="/images/guide/02.webp" alt="">
            <div class="space-y-2 leading-7">
                <h4 class="text-lg font-bold">အဆင့် ၂</h4>
                <p>​Login မဝင်ရသေးပါက Login Page ပေါ်လာမည်ဖြစ်ပြီး Login ဝင်ထားပြီးသားဖြစ်ပါက အောက်မှ အဆင့် (၃)
                    သို့ရောက်သွားပါမယ်။</p>
                <p>Login မဝင်ရသေးလျှင် <br>
                    (1) Social network account များဖြင့်လည်း Login ဝင်နိုင်သလို၊ <br>
                    (2) ဤ website တွင် register လုပ်ထားသောအကောင့်နှင့်လည်း ဝင်နိုင်ပါတယ်။</p>
            </div>
        </div>

        <div class="items-center grid-cols-2 gap-4 space-y-6 lg:space-y-0 lg:grid">
            <div class="space-y-2 leading-7">
                <h4 class="text-lg font-bold">အဆင့် ၃</h4>
                <p>Login ဝင်ပြီးနောက် အိမ်ခြံမြေတင်နိုင်သော စာမျက်နှာသို့ ရောက်ရှိမည်ဖြစ်ပါသည်။ ဤစာမျက်နှာမှ
                    လုပ်ဆောင်ချက်များကို ပုံပေါ်တွေ အညွှန်းများဖြင့် ရေးပြထားပါသည်။</p>
            </div>
            <img class="rounded shadow" src="/images/guide/03.webp" alt="">
        </div>

        <div class="items-center grid-cols-2 gap-4 space-y-6 lg:space-y-0 lg:grid">
            <img class="rounded shadow" src="/images/guide/04.webp" alt="">
            <div class="space-y-2 leading-7">
                <h4 class="text-lg font-bold">အဆင့် ၄</h4>
                <p>ဤ ပုံတွင်ပါရှိသော အမှတ်စဉ်များမှာ</p>
                <ol class="ml-8" style="list-style-type: decimal!important;">
                    <li>စုစုပေါင်း တင်ထားသော အိမ်ခြံမြေများနှင့် စုစုပေါင်း စုံစမ်းမေးမြန်မှုများ ကြည့်နိုင်ရန်</li>
                    <li>အိမ်ခြံမြေများနှင့်ပတ်သတ်သော ဆက်သွယ်မှု messageများကိုကြည့်နိုင်ရန်</li>
                    <li>အကောင့်လုံခြုံရေးနှင့်ဆိုင်သော လုပ်ဆောင်ချက်များ လုပ်ဆောင်နိုင်ရန်</li>
                    <li>အကောင့်အချက်အလက်အားလုံးကို ပြင်ဆင်နိုင်ရန်</li>
                    <li>Website ကြည့်နေစဉ်အတွင်း သိမ်းဆည်းထားသော အိမ်ခြံမြေများကို တစ်စုတစ်စည်းထဲ ကြည့်နိုင်ရန်</li>
                    <li>မိမိတင်ခဲ့သော အိမ်ခြံမြေများ (ဤထဲဝင်လိုက်လျှင် နံပါတ် ၈ ပါသော မြင်ကွင်းကိုရောက်မည်)</li>
                    <li>Featured Properties နေရာတွင်ကြော်ငြာရန် credit လိုအပ်ပါက ဤနေရာတွင် ဆက်သွယ်ဝယ်ယူရန်</li>
                    <li>ဤနံပါတ်တွင်ပါဝင်သော iconများမှာ
                        <ul class="mt-2">
                            <li class="flex">
                                <x-icon.icon :class="'w-6 h-6 mr-2 shrink-0'"
                                    :path="'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'" />
                                တင်ထားသော စာရင်းအား မည်သို့ပေါ်နေမည်ကို ကြည့်ရန်
                            </li>
                            <li class="flex">
                                <x-icon.icon :class="'w-6 h-6 mr-2 shrink-0'"
                                    :path="'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'" />
                                ရောင်းမထွက်သေးသော အိမ်ခြံမြေများအား အသစ်ပြန်တင်ရန်မလိုဘဲ ဤခလုတ်ကိုနှိပ်ခြင်းအားဖြင့်
                                အသစ်တဖန်ပြန်ဖြစ်စေပါသည်။
                            </li>
                            <li class="flex">
                                <x-icon.icon :class="'w-6 h-6 mr-2 shrink-0'"
                                    :path="'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'" />
                                Featured properties နေရာတွင်ကြော်ငြာရန် ဤခလုတ်ကိုနှိပ်နိုင်ပါသည်။ Feature property
                                ပြုလုပ်ရန်အတွက် Credit ဝယ်ရန်လိုအပ်ပါသည်။ အမှတ် (၇) တွင်ဆက်သွယ်ဝယ်ယူနိုင်ပါသည်။
                            </li>
                            <li class="flex">
                                <x-icon.icon :class="'w-6 h-6 mr-2 shrink-0'"
                                    :path="'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
                                တင်ထားသော အိမ်ခြံမြေစာရင်းအား ပြင်ဆင်ရန်
                            </li>
                            <li class="flex">
                                <x-icon.icon :class="'w-6 h-6 mr-2 shrink-0'"
                                    :path="'M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2'" />
                                ပုံစံဆင်တူသော စာရင်းများအား အစအဆုံးအသစ်ပြန်တင်ရန်မလိုဘဲ အနီးစပ်ဆုံးတူသော စာရင်းမှ
                                ဤခလုတ်အားနှိပ်ပြီး မတူသောအပိုင်းကိုသာ ပြင်ဆင်ခြင်းအားဖြင့် လွယ်ကူလျှင်မြန်စွာ
                                တင်နိုင်ပါသည်။
                            </li>
                            <li class="flex">
                                <x-icon.icon :class="'w-6 h-6 mr-2 shrink-0'"
                                    :path="'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'" />
                                ရောင်းထွက်ပြီးသောစာရင်းအား ဖျက်ရန်မလိုဘဲ ဤခလုတ်အားနှိပ်ပြီး သိမ်းဆည်းထားနိုင်သည်။
                            </li>
                            <li class="flex">
                                <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                                စာရင်းအား ဖျက်ရန်
                            </li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
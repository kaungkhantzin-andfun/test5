<div class="pb-10">
    <div class="relative bg-gray-900">
        <img class="object-cover w-full opacity-70 h-80" src="{{asset('assets/images/contact-banner.jpg')}}" alt="Contact Myanmar House">
        <h1 class="absolute inset-0 h-5 my-auto text-4xl text-center text-yellow-400">{{ __( $title ) }}</h1>
    </div>

    {{-- <div class="container grid items-center grid-cols-2 gap-8 mx-auto mt-8"> --}}
        <div class="container px-2 mx-auto mt-6 space-y-12 lg:space-y-0 lg:grid lg:items-top lg:grid-cols-2 lg:gap-6">
            <div>
                <h3 class="mb-3 text-2xl uppercase">{{ __('Send an email to us!') }}</h3>

                <livewire:contact-form />

            </div>

            <div>
                <p class="mb-4 leading-9">Myanmar House သည် တရားဝင် မှတ်ပုံတင်ထားသော ကုမ္ပဏီဖြစ်ပြီး
                    ရင်းနှီးမြှုပ်နှံမှုနှင့် ကုမ္ပဏီများညွှန်ကြားမှု ဦးစီးဌာနမှ ကုမ္ပဏီမှတ်ပုံတင်အမှတ် 120893238 နှင့်
                    မြန်မာနိုင်ငံ အိမ် ခြံ မြေ ဝန်ဆောင်မှု့အသင်း နှင့် အာဆီယံ အိမ်ခြံမြေကွန်ယက် မဟာမိတ်အဖွဲ့ တို့မှ
                    အသင်းဝင်အမှတ် ( က ၇၂၈၇ ) ဖြင့်ဝင်ရောက်ထားသော အိမ် ခြံ မြေ တစ်ခုဖြစ်ပါသည်။</p>

                <x-contact-info />
            </div>
        </div>

        <div class="container pt-10 mx-auto mt-6">
            <iframe class="w-full overflow-hidden rounded shadow-lg" style="height: 500px"
                src="https://www.google.com/maps/d/u/0/embed?mid=1zHNlhcEvEE-3LOey8QwqfFgIuQ_-XUph"></iframe>
        </div>
    </div>
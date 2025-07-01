<form wire:submit.prevent="sendMail" class="relative flex flex-col" action="#">
    @csrf

    <x-notices />

    <div class="space-y-3">
        <x-input.text model="name" label="Name" />
        <x-input.text model="phone" label="Phone number" />
        <x-input.text model="email" type="email" label="Email address" />

        {{-- @if (!$creditPage)
        <div>
            <span class="label">{{__('I am a')}}</span>
        <x-input.select label="" model="title">
            <option value="Buyer / Renter">{{__('Buyer / Renter')}}</option>
            <option value="Agent">{{__('Agent')}}</option>
            <option value="Other">{{__('Other')}}</option>
        </x-input.select>
    </div>
    @endif --}}

    <x-input.textarea model="msg" label="Message" class="h-24 p-3" />

    <button wire:loading.attr="disabled" wire:target="sendMail"
        class="float-right bg-gradient-to-r blue-gradient btn disabled:bg-gray-400">
        <span wire:loading.remove wire:target="sendMail" class="flex items-center justify-center gap-2">
            <x-icon.icon class="" :add-class="true" path="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            {{ __('Send') }}
        </span>

        <span wire:loading wire:target="sendMail" class="flex items-center justify-center gap-2 ">
            <i class="animate-spin fas fa-spinner"></i>
            {{ __('Sending ...') }}
        </span>
    </button>
    </div>
</form>
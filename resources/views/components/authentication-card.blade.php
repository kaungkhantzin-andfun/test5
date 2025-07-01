<div class="flex relative flex-col items-center min-h-[calc(100vh-150px)] overflow-hidden bg-indigo-50 justify-center">

    <div
        class="absolute inset-0 z-0 items-center justify-center hidden bg-blue-100 rounded-full sm:flex w-96 h-96 -left-20 -top-20 md:-top-32 lg:-top-36">
    </div>

    <div class="relative z-10 w-full px-6 py-4 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
        {{ $slot }}
    </div>

    <img class="absolute bottom-0 right-0 hidden sm:block w-44 lg:w-52 lg:right-10 xl:right-20 xl:w-60" src="{{asset('assets/images/trees.svg')}}"
        alt="Tree image in vector format">
</div>
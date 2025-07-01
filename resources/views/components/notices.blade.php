<div x-data="noticesHandler()" @notice.window="add($event.detail)" style="pointer-events:none"
    class="fixed inset-0 z-10 flex flex-col-reverse items-end justify-start w-screen h-screen">
    <template x-for="notice of notices" :key="notice.id">
        <div x-show="visible.includes(notice)" x-transition:enter="transition ease-in duration-200" x-transition:enter-start=opacity-0 translate-y-2"
            x-transition:enter-end=opacity-100" x-transition:leave="transition ease-out duration-500" x-transition:leave-start=translate-x-0
            opacity-100" x-transition:leave-end=translate-x-full opacity-0" @click="remove(notice.id)"
            class="relative flex items-center justify-center px-4 py-2 mb-4 mr-6 text-lg text-white rounded shadow-lg cursor-pointer bottom-12"
            :class="{
				'bg-green-500': notice.type === 'success',
				'bg-blue-500': notice.type === 'info',
				'bg-orange-500': notice.type === 'warning',
				'bg-red-500': notice.type === 'error',
			 }" style="pointer-events:all" x-text="notice.text">
        </div>
    </template>

    <script>
        function noticesHandler() {
            return {
                notices: [],
                visible: [],
                add(notice) {
                    notice.id = Date.now()
                    this.notices.push(notice)
                    this.fire(notice.id)
                },
                fire(id) {
                    this.visible.push(this.notices.find(notice => notice.id == id))
                    const timeShown = 3000
                    setTimeout(() => {
                        this.remove(id)
                    }, timeShown)
                },
                remove(id) {
                    const notice = this.visible.find(notice => notice.id == id)
                    const index = this.visible.indexOf(notice)
                    this.visible.splice(index, 1)
                },
            }
        }
    </script>

</div>
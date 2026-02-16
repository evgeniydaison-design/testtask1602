<script setup lang="ts">
const props = defineProps<{
  filterId: string
  openFilterId: string | null
  minPrice?: number
  maxPrice?: number
}>()

const emit = defineEmits<{
  update: [payload: { min_price?: number; max_price?: number }]
  open: []
  close: []
}>()

const isOpen = computed(() => props.openFilterId === props.filterId)
const dropdownRef = ref<HTMLElement | null>(null)

const displayValue = computed(() => {
  if (!props.minPrice && !props.maxPrice) return ''
  if (props.minPrice && props.maxPrice) return `${props.minPrice.toLocaleString()} – ${props.maxPrice.toLocaleString()} ₽`
  if (props.minPrice) return `от ${props.minPrice.toLocaleString()} ₽`
  if (props.maxPrice) return `до ${props.maxPrice.toLocaleString()} ₽`
  return ''
})

// локальные значения пока не нажали "применить"
const localMin = ref('')
const localMax = ref('')

watch(
  () => [props.minPrice, props.maxPrice],
  () => {
    localMin.value = props.minPrice ? String(props.minPrice) : ''
    localMax.value = props.maxPrice ? String(props.maxPrice) : ''
  },
  { immediate: true }
)

function apply() {
  const min = localMin.value ? Number(localMin.value) : undefined
  const max = localMax.value ? Number(localMax.value) : undefined
  emit('update', { min_price: min, max_price: max })
  emit('close')
}

function toggle() {
  emit(isOpen.value ? 'close' : 'open')
}

function onClickOutside(event: MouseEvent) {
  const target = event.target as Node
  if (dropdownRef.value && !dropdownRef.value.contains(target)) {
    emit('close')
  }
}

onMounted(() => {
  document.addEventListener('click', onClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', onClickOutside)
})
</script>

<template>
  <div ref="dropdownRef" class="relative">
    <button
      type="button"
      class="w-full flex flex-col items-start gap-1 py-2 text-left hover:opacity-80 transition-opacity"
      @click.stop="toggle"
    >
      <div class="flex items-center justify-between w-full">
        <span class="text-sm font-medium text-gray-700">Цена</span>
        <svg
          class="w-4 h-4 text-gray-500 transition-transform shrink-0"
          :class="{ 'rotate-180': isOpen }"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </div>
      <span
        class="text-sm"
        :class="displayValue ? 'text-gray-900 font-medium' : 'text-gray-400'"
      >
        {{ displayValue || 'Любая' }}
      </span>
    </button>

    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 -translate-x-2"
      enter-to-class="opacity-100 translate-x-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 translate-x-0"
      leave-to-class="opacity-0 -translate-x-2"
    >
      <div
        v-show="isOpen"
        class="absolute left-full top-0 z-20 ml-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-3 px-3"
      >
        <div class="flex gap-2">
          <div class="flex-1">
            <label class="block text-xs text-gray-500 mb-1">С</label>
            <input
              v-model="localMin"
              type="number"
              placeholder="0"
              min="0"
              class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none"
              @keyup.enter="apply"
            />
          </div>
          <div class="flex-1">
            <label class="block text-xs text-gray-500 mb-1">До</label>
            <input
              v-model="localMax"
              type="number"
              placeholder="∞"
              min="0"
              class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none"
              @keyup.enter="apply"
            />
          </div>
        </div>
        <button
          type="button"
          class="mt-3 w-full py-2 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors"
          @click="apply"
        >
          Применить
        </button>
      </div>
    </Transition>
  </div>
</template>

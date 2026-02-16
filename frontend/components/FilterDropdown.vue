<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    filterId: string
    openFilterId: string | null
    label: string
    options: { value: string; label: string }[]
    modelValue?: string
    placeholder?: string
  }>(),
  { placeholder: 'Любое' }
)

const emit = defineEmits<{
  'update:modelValue': [value: string | undefined]
  open: []
  close: []
}>()

const isOpen = computed(() => props.openFilterId === props.filterId)
const dropdownRef = ref<HTMLElement | null>(null)

const selectedLabel = computed(() => {
  if (!props.modelValue) return ''
  return props.options.find((o) => o.value === props.modelValue)?.label ?? props.modelValue
})

function toggle() {
  emit(isOpen.value ? 'close' : 'open')
}

function select(value: string) {
  const newValue = value === props.modelValue ? undefined : value
  emit('update:modelValue', newValue)
  emit('close')
}

// клик вне — закрыть
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
        <span class="text-sm font-medium text-gray-700">{{ label }}</span>
        <svg
          class="w-4 h-4 text-gray-500 transition-transform shrink-0"
          :class="{ 'rotate-90': isOpen }"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </div>
      <span
        class="text-sm"
        :class="selectedLabel ? 'text-gray-900 font-medium' : 'text-gray-400'"
      >
        {{ selectedLabel || placeholder }}
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
        class="absolute left-full top-0 z-20 ml-2 w-48 min-w-max bg-white rounded-xl shadow-lg border border-gray-100 py-3 px-3 max-h-64 overflow-y-auto"
      >
        <div class="space-y-1">
          <label
            v-for="opt in options"
            :key="opt.value"
            class="flex items-center gap-3 py-2 px-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors"
          >
            <span
              class="w-4 h-4 rounded-full border-2 flex items-center justify-center shrink-0 transition-colors"
              :class="
                modelValue === opt.value
                  ? 'border-blue-500 bg-blue-500'
                  : 'border-gray-300 bg-white'
              "
            >
              <span
                v-if="modelValue === opt.value"
                class="w-1.5 h-1.5 rounded-full bg-white"
              />
            </span>
            <span
              class="text-sm"
              :class="modelValue === opt.value ? 'text-blue-600 font-medium' : 'text-gray-700'"
            >
              {{ opt.label }}
            </span>
            <input
              type="radio"
              :name="label"
              :value="opt.value"
              :checked="modelValue === opt.value"
              class="sr-only"
              @change="select(opt.value)"
            />
          </label>
        </div>
      </div>
    </Transition>
  </div>
</template>

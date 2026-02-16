<script setup lang="ts">
const props = defineProps<{
  currentPage: number
  lastPage: number
  total: number
  from: number | null
  to: number | null
}>()

const emit = defineEmits<{
  page: [page: number]
}>()

const pages = computed(() => {
  const result: (number | 'ellipsis')[] = []
  const total = props.lastPage
  const current = props.currentPage

  if (total <= 7) {
    for (let i = 1; i <= total; i++) result.push(i)
  } else {
    result.push(1)
    if (current > 3) result.push('ellipsis')
    for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) {
      if (!result.includes(i)) result.push(i)
    }
    if (current < total - 2) result.push('ellipsis')
    if (total > 1) result.push(total)
  }
  return result.filter((v, i, a) => {
    if (v === 'ellipsis' && a[i - 1] === 'ellipsis') return false
    return true
  })
})
</script>

<template>
  <div v-if="lastPage > 1" class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
    <p class="text-sm text-gray-600">
      Показано {{ from ?? 0 }}-{{ to ?? 0 }} из {{ total }}
    </p>
    <nav class="flex items-center gap-1">
      <button
        :disabled="currentPage <= 1"
        @click="emit('page', currentPage - 1)"
        class="px-3 py-2 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        Назад
      </button>
      <template v-for="(p, i) in pages" :key="i">
        <button
          v-if="p !== 'ellipsis'"
          @click="emit('page', p)"
          :class="[
            'px-3 py-2 rounded-lg text-sm font-medium min-w-[2.5rem]',
            p === currentPage
              ? 'bg-primary-600 text-white'
              : 'border border-gray-300 text-gray-700 hover:bg-gray-50'
          ]"
        >
          {{ p }}
        </button>
        <span v-else class="px-2 text-gray-400">...</span>
      </template>
      <button
        :disabled="currentPage >= lastPage"
        @click="emit('page', currentPage + 1)"
        class="px-3 py-2 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        Вперёд
      </button>
    </nav>
  </div>
</template>

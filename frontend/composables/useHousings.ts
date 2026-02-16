import type { HousingApiResponse, HousingFilters } from '~/types/housing'

export function useHousings(filters: Ref<HousingFilters>) {
  const config = useRuntimeConfig()
  const apiBase = config.public.apiBase as string

  const query = computed(() => {
    const q: Record<string, string | number> = {
      page: filters.value.page || 1,
    }
    if (filters.value.city) q.city = filters.value.city
    if (filters.value.min_price) q.min_price = filters.value.min_price
    if (filters.value.max_price) q.max_price = filters.value.max_price
    if (filters.value.guests) q.guests = filters.value.guests
    if (filters.value.sort) q.sort = filters.value.sort
    return q
  })

  // key нужен чтобы useFetch перезапрашивал при смене фильтров
  const fetchKey = computed(() => `housings-${JSON.stringify(query.value)}`)

  const { data, pending, error, refresh } = useFetch<HousingApiResponse>(
    `${apiBase}/housings`,
    {
      query,
      key: fetchKey,
    }
  )

  return {
    housings: computed(() => data.value?.data ?? []),
    pagination: computed(() => data.value?.meta ?? null),
    links: computed(() => data.value?.links ?? null),
    pending,
    error,
    refresh,
  }
}

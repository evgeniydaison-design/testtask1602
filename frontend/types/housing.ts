export interface Housing {
  id: number
  title: string
  city: string
  address: string
  price: number
  guests: number
  bedrooms: number
  beds: number
  baths: number
  image_url: string
  description: string
  amenities: string[]
}

export interface HousingFilters {
  city?: string
  min_price?: number
  max_price?: number
  guests?: number
  sort?: 'price_asc' | 'price_desc' | 'newest'
  page?: number
}

export interface HousingApiResponse {
  data: Housing[]
  links: {
    first: string
    last: string
    prev: string | null
    next: string | null
  }
  meta: {
    current_page: number
    from: number | null
    last_page: number
    per_page: number
    to: number | null
    total: number
  }
}

// Marketplace Types

export interface Seller {
  id: number
  name: string
  email: string
  company_name?: string
  status: 'pending' | 'approved' | 'rejected' | 'suspended'
  rating: number
  total_sales: number
  commission_rate: number
  created_at: string
  updated_at: string
  approved_at?: string
  rejected_at?: string
  rejection_reason?: string
}

export interface Product {
  id: number
  seller_id: number
  name: string
  sku: string
  price: number
  stock: number
  status: 'active' | 'inactive' | 'pending'
  created_at: string
  updated_at: string
}

export interface Review {
  id: number
  seller_id: number
  customer_id: number
  rating: number
  title: string
  comment: string
  status: 'pending' | 'approved' | 'rejected'
  created_at: string
}

export interface Message {
  id: number
  seller_id: number
  customer_id: number
  subject: string
  message: string
  status: 'unread' | 'read' | 'replied'
  created_at: string
}

export interface MarketplaceStats {
  total_sellers: number
  pending_sellers: number
  approved_sellers: number
  total_products: number
  total_reviews: number
  total_messages: number
  average_rating: number
}

export interface ApiResponse<T> {
  data: T
  message?: string
  success: boolean
}

export interface PaginatedResponse<T> {
  items: T[]
  total: number
  page: number
  page_size: number
}

export interface ActivityLog {
  date: string
  action: string
  details: string
}


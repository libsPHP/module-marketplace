import axios, { AxiosInstance } from 'axios'
import type {
  Seller,
  Product,
  Review,
  MarketplaceStats,
  PaginatedResponse,
  ActivityLog,
} from '../types/marketplace'

class MagentoApiService {
  private api: AxiosInstance

  constructor() {
    this.api = axios.create({
      baseURL: '/rest/V1',
      headers: {
        'Content-Type': 'application/json',
      },
    })

    // Add auth token interceptor
    this.api.interceptors.request.use((config) => {
      const token = localStorage.getItem('admin_token')
      if (token) {
        config.headers.Authorization = `Bearer ${token}`
      }
      return config
    })
  }

  // Authentication
  async login(username: string, password: string): Promise<string> {
    const response = await this.api.post('/integration/admin/token', {
      username,
      password,
    })
    return response.data
  }

  // Statistics
  async getStats(): Promise<MarketplaceStats> {
    const response = await this.api.get('/marketplace/admin/stats')
    return response.data
  }

  // Sellers
  async getPendingSellers(
    pageSize = 20,
    currentPage = 1
  ): Promise<PaginatedResponse<Seller>> {
    const response = await this.api.get('/marketplace/admin/sellers/pending', {
      params: { pageSize, currentPage },
    })
    return response.data
  }

  async approveSeller(sellerId: number): Promise<boolean> {
    const response = await this.api.post(
      `/marketplace/admin/sellers/${sellerId}/approve`
    )
    return response.data
  }

  async rejectSeller(sellerId: number, reason: string): Promise<boolean> {
    const response = await this.api.post(
      `/marketplace/admin/sellers/${sellerId}/reject`,
      { reason }
    )
    return response.data
  }

  async bulkApproveSellers(sellerIds: number[]): Promise<{
    success: number[]
    failed: Array<{ seller_id: number; error: string }>
  }> {
    const response = await this.api.post(
      '/marketplace/admin/sellers/bulk-approve',
      { sellerIds }
    )
    return response.data
  }

  async bulkRejectSellers(
    sellerIds: number[],
    reason: string
  ): Promise<{
    success: number[]
    failed: Array<{ seller_id: number; error: string }>
  }> {
    const response = await this.api.post(
      '/marketplace/admin/sellers/bulk-reject',
      { sellerIds, reason }
    )
    return response.data
  }

  async updateSellerStatus(
    sellerId: number,
    status: string
  ): Promise<boolean> {
    const response = await this.api.put(
      `/marketplace/admin/sellers/${sellerId}/status`,
      { status }
    )
    return response.data
  }

  async getSellerActivity(
    sellerId: number,
    limit = 50
  ): Promise<ActivityLog[]> {
    const response = await this.api.get(
      `/marketplace/admin/sellers/${sellerId}/activity`,
      { params: { limit } }
    )
    return response.data
  }

  // Configuration
  async getConfiguration(): Promise<Record<string, any>> {
    const response = await this.api.get('/marketplace/admin/configuration')
    return response.data
  }

  async updateConfiguration(config: Record<string, any>): Promise<boolean> {
    const response = await this.api.post(
      '/marketplace/admin/configuration',
      config
    )
    return response.data
  }

  // Sellers (standard API)
  async getAllSellers(): Promise<Seller[]> {
    const response = await this.api.get('/marketplace/sellers')
    return response.data
  }

  async getSeller(sellerId: number): Promise<Seller> {
    const response = await this.api.get(`/marketplace/sellers/${sellerId}`)
    return response.data
  }

  // Products
  async getProducts(): Promise<Product[]> {
    const response = await this.api.get('/marketplace/products')
    return response.data
  }

  // Reviews
  async getReviews(): Promise<Review[]> {
    const response = await this.api.get('/marketplace/reviews')
    return response.data
  }
}

export const magentoApi = new MagentoApiService()


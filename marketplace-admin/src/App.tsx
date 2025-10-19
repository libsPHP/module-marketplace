import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom'
import { Layout } from './components/layout/Layout'
import { Dashboard } from './components/dashboard/Dashboard'
import { SellersList } from './components/sellers/SellersList'
import { ApprovalQueue } from './components/sellers/ApprovalQueue'
import { ProductsList } from './components/products/ProductsList'
import { ReviewsList } from './components/reviews/ReviewsList'

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<Navigate to="/dashboard" replace />} />
          <Route path="dashboard" element={<Dashboard />} />
          <Route path="sellers" element={<SellersList />} />
          <Route path="sellers/pending" element={<ApprovalQueue />} />
          <Route path="products" element={<ProductsList />} />
          <Route path="reviews" element={<ReviewsList />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App


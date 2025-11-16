import React, { useState } from 'react';
import { ShoppingBag, TrendingUp, DollarSign, Package, Plus, Star, Eye, Camera, CreditCard as Edit, Trash2, MessageCircle, Heart, Clock, MapPin, Filter, Search, X, Upload, Tag, Calendar, BarChart3, Users, Award, Crown, AlertCircle, CheckCircle, RefreshCw, Phone, Mail, Share, Download, Settings, Bell, Target, PieChart, TrendingDown, Zap, Gift } from 'lucide-react';

interface SellerDashboardProps {
  userName: string;
}

interface ListingItem {
  id: string;
  title: string;
  description: string;
  price: number;
  originalPrice: number;
  category: string;
  condition: string;
  size?: string;
  color?: string;
  brand?: string;
  images: string[];
  status: 'active' | 'sold' | 'pending' | 'draft';
  views: number;
  likes: number;
  inquiries: number;
  datePosted: string;
  featured: boolean;
  promoted: boolean;
}

interface Inquiry {
  id: string;
  itemId: string;
  itemTitle: string;
  buyerName: string;
  buyerEmail: string;
  message: string;
  date: string;
  status: 'new' | 'replied' | 'closed';
  offer?: number;
}

interface Sale {
  id: string;
  itemTitle: string;
  buyerName: string;
  salePrice: number;
  commission: number;
  netEarnings: number;
  saleDate: string;
  status: 'completed' | 'processing' | 'shipped';
  trackingNumber?: string;
}

const SellerDashboard: React.FC<SellerDashboardProps> = ({ userName }) => {
  const [selectedTab, setSelectedTab] = useState('overview');
  const [showAddItemModal, setShowAddItemModal] = useState(false);
  const [showInquiryModal, setShowInquiryModal] = useState(false);
  const [selectedInquiry, setSelectedInquiry] = useState<Inquiry | null>(null);
  const [searchTerm, setSearchTerm] = useState('');
  const [filterStatus, setFilterStatus] = useState('all');
  const [filterCategory, setFilterCategory] = useState('all');

  const tabs = [
    { id: 'overview', label: 'Overview', icon: TrendingUp },
    { id: 'listings', label: 'My Listings', icon: Package },
    { id: 'inquiries', label: 'Inquiries', icon: MessageCircle },
    { id: 'sales', label: 'Sales History', icon: DollarSign },
    { id: 'analytics', label: 'Analytics', icon: BarChart3 },
    { id: 'promotion', label: 'Promotion', icon: Zap },
    { id: 'profile', label: 'Seller Profile', icon: Users },
    { id: 'settings', label: 'Settings', icon: Settings }
  ];

  const stats = [
    { label: 'Active Listings', value: '18', change: '+3', icon: Package, color: 'teal', trend: 'up' },
    { label: 'Total Sales', value: 'R24,750', change: '+15%', icon: DollarSign, color: 'green', trend: 'up' },
    { label: 'Total Views', value: '2,847', change: '+22%', icon: Eye, color: 'blue', trend: 'up' },
    { label: 'Seller Rating', value: '4.8', change: '+0.2', icon: Star, color: 'yellow', trend: 'up' }
  ];

  const mockListings: ListingItem[] = [
    {
      id: '1',
      title: 'Vintage Lace Wedding Dress - Size 10',
      description: 'Beautiful vintage lace wedding dress, worn once. Includes veil and accessories. Professionally cleaned.',
      price: 2500,
      originalPrice: 8000,
      category: 'Wedding Dress',
      condition: 'Excellent',
      size: '10',
      color: 'Ivory',
      brand: 'Vera Wang',
      images: ['https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=400'],
      status: 'active',
      views: 234,
      likes: 18,
      inquiries: 5,
      datePosted: '2024-12-15',
      featured: true,
      promoted: false
    },
    {
      id: '2',
      title: 'Crystal Centerpieces Set of 8',
      description: 'Elegant crystal centerpieces with LED lights. Perfect for reception tables. Used once.',
      price: 800,
      originalPrice: 2400,
      category: 'Decorations',
      condition: 'Like New',
      images: ['https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=400'],
      status: 'sold',
      views: 156,
      likes: 12,
      inquiries: 8,
      datePosted: '2024-12-10',
      featured: false,
      promoted: true
    },
    {
      id: '3',
      title: 'Men\'s Wedding Suit - 42R',
      description: 'Classic black tuxedo with accessories. Dry cleaned and in perfect condition.',
      price: 1200,
      originalPrice: 3500,
      category: 'Groom Attire',
      condition: 'Excellent',
      size: '42R',
      color: 'Black',
      images: ['https://images.pexels.com/photos/1024996/pexels-photo-1024996.jpeg?auto=compress&cs=tinysrgb&w=400'],
      status: 'active',
      views: 89,
      likes: 6,
      inquiries: 3,
      datePosted: '2024-12-12',
      featured: false,
      promoted: false
    }
  ];

  const mockInquiries: Inquiry[] = [
    {
      id: '1',
      itemId: '1',
      itemTitle: 'Vintage Lace Wedding Dress - Size 10',
      buyerName: 'Sarah Johnson',
      buyerEmail: 'sarah@email.com',
      message: 'Hi! I\'m interested in this dress. Is it still available? Can I see more photos?',
      date: '2024-12-20',
      status: 'new',
      offer: 2200
    },
    {
      id: '2',
      itemId: '3',
      itemTitle: 'Men\'s Wedding Suit - 42R',
      buyerName: 'Michael Smith',
      buyerEmail: 'michael@email.com',
      message: 'Would you consider R1000 for the suit?',
      date: '2024-12-19',
      status: 'replied'
    }
  ];

  const mockSales: Sale[] = [
    {
      id: '1',
      itemTitle: 'Crystal Centerpieces Set of 8',
      buyerName: 'Emma Wilson',
      salePrice: 800,
      commission: 80,
      netEarnings: 720,
      saleDate: '2024-12-18',
      status: 'completed',
      trackingNumber: 'KN123456789'
    },
    {
      id: '2',
      itemTitle: 'Wedding Arch with Flowers',
      buyerName: 'Lisa Brown',
      salePrice: 1200,
      commission: 120,
      netEarnings: 1080,
      saleDate: '2024-12-15',
      status: 'completed'
    }
  ];

  const categories = ['All', 'Wedding Dress', 'Groom Attire', 'Jewelry', 'Decorations', 'Shoes', 'Accessories'];
  const conditions = ['Like New', 'Excellent', 'Good', 'Fair'];

  const filteredListings = mockListings.filter(item => {
    const matchesSearch = item.title.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesStatus = filterStatus === 'all' || item.status === filterStatus;
    const matchesCategory = filterCategory === 'all' || item.category === filterCategory;
    return matchesSearch && matchesStatus && matchesCategory;
  });

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'active': return 'bg-green-100 text-green-700';
      case 'sold': return 'bg-blue-100 text-blue-700';
      case 'pending': return 'bg-yellow-100 text-yellow-700';
      case 'draft': return 'bg-gray-100 text-gray-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  const getConditionColor = (condition: string) => {
    switch (condition) {
      case 'Like New': return 'bg-green-100 text-green-700';
      case 'Excellent': return 'bg-blue-100 text-blue-700';
      case 'Good': return 'bg-yellow-100 text-yellow-700';
      case 'Fair': return 'bg-orange-100 text-orange-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  const getInquiryStatusColor = (status: string) => {
    switch (status) {
      case 'new': return 'bg-red-100 text-red-700';
      case 'replied': return 'bg-blue-100 text-blue-700';
      case 'closed': return 'bg-gray-100 text-gray-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  return (
    <div className="p-6">
      {/* Header */}
      <div className="bg-gradient-to-r from-teal-500 to-cyan-600 rounded-2xl p-6 text-white mb-8">
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold mb-2">Welcome back, {userName}! 🛍️</h1>
            <p className="text-teal-100">Manage your pre-loved wedding items marketplace</p>
            <div className="flex items-center space-x-4 mt-3">
              <div className="flex items-center space-x-2">
                <Package className="h-4 w-4" />
                <span className="text-sm">18 Active Listings</span>
              </div>
              <div className="flex items-center space-x-2">
                <Star className="h-4 w-4" />
                <span className="text-sm">4.8 Seller Rating</span>
              </div>
            </div>
          </div>
          <div className="text-right">
            <div className="text-3xl font-bold">R24,750</div>
            <div className="text-sm text-teal-100">Total Earnings</div>
            <div className="flex items-center space-x-2 mt-2">
              <Crown className="h-5 w-5 text-yellow-400" />
              <span className="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">Top Seller</span>
            </div>
          </div>
        </div>
      </div>

      {/* Navigation Tabs */}
      <div className="mb-8">
        <div className="flex space-x-1 bg-white rounded-xl p-1 shadow-sm overflow-x-auto">
          {tabs.map((tab) => {
            const Icon = tab.icon;
            return (
              <button
                key={tab.id}
                onClick={() => setSelectedTab(tab.id)}
                className={`flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-all duration-200 whitespace-nowrap ${
                  selectedTab === tab.id
                    ? 'bg-teal-500 text-white shadow-md'
                    : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50'
                }`}
              >
                <Icon className="h-5 w-5" />
                <span>{tab.label}</span>
              </button>
            );
          })}
        </div>
      </div>

      {/* Content */}
      {selectedTab === 'overview' && (
        <div className="space-y-8">
          {/* Stats Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {stats.map((stat) => {
              const Icon = stat.icon;
              const TrendIcon = stat.trend === 'up' ? TrendingUp : TrendingDown;
              return (
                <div key={stat.label} className="bg-white rounded-xl p-6 shadow-sm">
                  <div className="flex items-center justify-between mb-4">
                    <div className={`w-10 h-10 bg-${stat.color}-100 rounded-lg flex items-center justify-center`}>
                      <Icon className={`h-5 w-5 text-${stat.color}-600`} />
                    </div>
                    <div className={`flex items-center space-x-1 text-sm ${
                      stat.trend === 'up' ? 'text-green-600' : 'text-red-600'
                    }`}>
                      <TrendIcon className="h-4 w-4" />
                      <span>{stat.change}</span>
                    </div>
                  </div>
                  <div className="text-2xl font-bold text-gray-900 mb-1">{stat.value}</div>
                  <div className="text-sm text-gray-600">{stat.label}</div>
                </div>
              );
            })}
          </div>

          {/* Quick Actions */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="font-semibold text-gray-900 mb-4">Quick Actions</h3>
              <div className="space-y-3">
                <button 
                  onClick={() => setShowAddItemModal(true)}
                  className="w-full bg-teal-500 text-white py-3 rounded-lg font-medium hover:bg-teal-600 transition-colors flex items-center justify-center space-x-2"
                >
                  <Plus className="h-4 w-4" />
                  <span>Add New Item</span>
                </button>
                <button className="w-full border border-teal-300 text-teal-600 py-3 rounded-lg font-medium hover:bg-teal-50 transition-colors flex items-center justify-center space-x-2">
                  <Zap className="h-4 w-4" />
                  <span>Promote Listings</span>
                </button>
                <button className="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center justify-center space-x-2">
                  <BarChart3 className="h-4 w-4" />
                  <span>View Analytics</span>
                </button>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="font-semibold text-gray-900 mb-4">Recent Activity</h3>
              <div className="space-y-3">
                <div className="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                  <CheckCircle className="h-5 w-5 text-green-600" />
                  <div className="flex-1">
                    <div className="text-sm font-medium text-gray-900">Item Sold</div>
                    <div className="text-xs text-gray-500">Crystal Centerpieces - R800</div>
                  </div>
                </div>
                <div className="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                  <MessageCircle className="h-5 w-5 text-blue-600" />
                  <div className="flex-1">
                    <div className="text-sm font-medium text-gray-900">New Inquiry</div>
                    <div className="text-xs text-gray-500">Wedding Dress - Sarah J.</div>
                  </div>
                </div>
                <div className="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg">
                  <Eye className="h-5 w-5 text-yellow-600" />
                  <div className="flex-1">
                    <div className="text-sm font-medium text-gray-900">High Views</div>
                    <div className="text-xs text-gray-500">Men's Suit - 89 views today</div>
                  </div>
                </div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="font-semibold text-gray-900 mb-4">Performance Tips</h3>
              <div className="space-y-3">
                <div className="p-3 bg-purple-50 rounded-lg">
                  <div className="text-sm font-medium text-purple-900 mb-1">Add More Photos</div>
                  <div className="text-xs text-purple-700">Items with 5+ photos get 40% more views</div>
                </div>
                <div className="p-3 bg-green-50 rounded-lg">
                  <div className="text-sm font-medium text-green-900 mb-1">Competitive Pricing</div>
                  <div className="text-xs text-green-700">Your prices are 15% below market average</div>
                </div>
                <div className="p-3 bg-blue-50 rounded-lg">
                  <div className="text-sm font-medium text-blue-900 mb-1">Quick Responses</div>
                  <div className="text-xs text-blue-700">Reply to inquiries within 2 hours</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'listings' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <h3 className="text-xl font-semibold text-gray-900">My Listings</h3>
            <button 
              onClick={() => setShowAddItemModal(true)}
              className="bg-gradient-to-r from-teal-500 to-cyan-600 text-white px-6 py-2 rounded-lg font-medium hover:from-teal-600 hover:to-cyan-700 transition-all duration-200"
            >
              <Plus className="h-4 w-4 inline mr-2" />
              Add New Item
            </button>
          </div>

          {/* Filters */}
          <div className="bg-white rounded-xl p-6 shadow-sm">
            <div className="flex flex-col md:flex-row gap-4">
              <div className="relative flex-1">
                <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                <input
                  type="text"
                  placeholder="Search your listings..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                />
              </div>
              <select
                value={filterStatus}
                onChange={(e) => setFilterStatus(e.target.value)}
                className="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
              >
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="sold">Sold</option>
                <option value="pending">Pending</option>
                <option value="draft">Draft</option>
              </select>
              <select
                value={filterCategory}
                onChange={(e) => setFilterCategory(e.target.value)}
                className="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
              >
                {categories.map(cat => (
                  <option key={cat} value={cat.toLowerCase()}>{cat}</option>
                ))}
              </select>
            </div>
          </div>

          {/* Listings Grid */}
          <div className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            {filteredListings.map((item) => (
              <div key={item.id} className="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                <div className="relative">
                  <img src={item.images[0]} alt={item.title} className="w-full h-48 object-cover" />
                  <div className="absolute top-3 left-3 flex space-x-2">
                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${getStatusColor(item.status)}`}>
                      {item.status}
                    </span>
                    {item.featured && (
                      <span className="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium flex items-center space-x-1">
                        <Crown className="h-3 w-3" />
                        <span>Featured</span>
                      </span>
                    )}
                  </div>
                  <div className="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full">
                    <span className="text-xs font-medium text-gray-700">
                      {Math.round(((item.originalPrice - item.price) / item.originalPrice) * 100)}% OFF
                    </span>
                  </div>
                </div>

                <div className="p-6">
                  <h4 className="font-semibold text-gray-900 mb-2 line-clamp-2">{item.title}</h4>
                  
                  <div className="flex items-center justify-between mb-3">
                    <div className="flex items-center space-x-2">
                      <span className="text-2xl font-bold text-teal-600">R{item.price.toLocaleString()}</span>
                      <span className="text-sm text-gray-500 line-through">R{item.originalPrice.toLocaleString()}</span>
                    </div>
                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${getConditionColor(item.condition)}`}>
                      {item.condition}
                    </span>
                  </div>

                  <div className="grid grid-cols-3 gap-4 mb-4 text-sm text-gray-600">
                    <div className="flex items-center space-x-1">
                      <Eye className="h-4 w-4" />
                      <span>{item.views}</span>
                    </div>
                    <div className="flex items-center space-x-1">
                      <Heart className="h-4 w-4" />
                      <span>{item.likes}</span>
                    </div>
                    <div className="flex items-center space-x-1">
                      <MessageCircle className="h-4 w-4" />
                      <span>{item.inquiries}</span>
                    </div>
                  </div>

                  <div className="flex space-x-2">
                    <button className="flex-1 bg-teal-500 text-white py-2 rounded-lg text-sm font-medium hover:bg-teal-600 transition-colors">
                      <Edit className="h-4 w-4 inline mr-1" />
                      Edit
                    </button>
                    <button className="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                      <Share className="h-4 w-4" />
                    </button>
                    <button className="px-3 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                      <Trash2 className="h-4 w-4" />
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      )}

      {selectedTab === 'inquiries' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <h3 className="text-xl font-semibold text-gray-900">Customer Inquiries</h3>
            <div className="flex items-center space-x-2">
              <span className="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                {mockInquiries.filter(i => i.status === 'new').length} New
              </span>
            </div>
          </div>

          <div className="space-y-4">
            {mockInquiries.map((inquiry) => (
              <div key={inquiry.id} className="bg-white rounded-xl p-6 shadow-sm">
                <div className="flex items-center justify-between mb-4">
                  <div className="flex items-center space-x-3">
                    <div className="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                      <Users className="h-5 w-5 text-teal-600" />
                    </div>
                    <div>
                      <h4 className="font-semibold text-gray-900">{inquiry.buyerName}</h4>
                      <p className="text-sm text-gray-600">{inquiry.buyerEmail}</p>
                    </div>
                  </div>
                  <div className="flex items-center space-x-3">
                    <span className={`px-3 py-1 rounded-full text-xs font-medium ${getInquiryStatusColor(inquiry.status)}`}>
                      {inquiry.status}
                    </span>
                    <span className="text-sm text-gray-500">{inquiry.date}</span>
                  </div>
                </div>

                <div className="mb-4">
                  <h5 className="font-medium text-gray-900 mb-2">Re: {inquiry.itemTitle}</h5>
                  <p className="text-gray-700 bg-gray-50 p-3 rounded-lg">{inquiry.message}</p>
                  {inquiry.offer && (
                    <div className="mt-2 p-3 bg-yellow-50 rounded-lg">
                      <span className="text-sm font-medium text-yellow-800">
                        Offer: R{inquiry.offer.toLocaleString()}
                      </span>
                    </div>
                  )}
                </div>

                <div className="flex space-x-3">
                  <button 
                    onClick={() => {
                      setSelectedInquiry(inquiry);
                      setShowInquiryModal(true);
                    }}
                    className="bg-teal-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-teal-600 transition-colors"
                  >
                    Reply
                  </button>
                  <button className="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <Phone className="h-4 w-4 inline mr-1" />
                    Call
                  </button>
                  <button className="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <Mail className="h-4 w-4 inline mr-1" />
                    Email
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      )}

      {selectedTab === 'sales' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <h3 className="text-xl font-semibold text-gray-900">Sales History</h3>
            <button className="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition-colors">
              <Download className="h-4 w-4 inline mr-2" />
              Export
            </button>
          </div>

          {/* Sales Summary */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="text-2xl font-bold text-gray-900">R24,750</div>
              <div className="text-sm text-gray-600">Total Sales</div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="text-2xl font-bold text-gray-900">R2,475</div>
              <div className="text-sm text-gray-600">Platform Fees</div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="text-2xl font-bold text-green-600">R22,275</div>
              <div className="text-sm text-gray-600">Net Earnings</div>
            </div>
          </div>

          {/* Sales Table */}
          <div className="bg-white rounded-xl shadow-sm overflow-hidden">
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale Price</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Earnings</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  {mockSales.map((sale) => (
                    <tr key={sale.id} className="hover:bg-gray-50">
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="font-medium text-gray-900">{sale.itemTitle}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm text-gray-900">{sale.buyerName}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm font-medium text-gray-900">R{sale.salePrice.toLocaleString()}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm text-red-600">R{sale.commission.toLocaleString()}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm font-medium text-green-600">R{sale.netEarnings.toLocaleString()}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm text-gray-500">{sale.saleDate}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                          sale.status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'
                        }`}>
                          {sale.status}
                        </span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'analytics' && (
        <div className="space-y-6">
          <h3 className="text-xl font-semibold text-gray-900">Sales Analytics</h3>
          
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Performance Overview</h4>
              <div className="space-y-4">
                <div className="flex justify-between items-center">
                  <span className="text-gray-600">Conversion Rate</span>
                  <span className="font-medium text-gray-900">12.5%</span>
                </div>
                <div className="flex justify-between items-center">
                  <span className="text-gray-600">Average Sale Price</span>
                  <span className="font-medium text-gray-900">R1,375</span>
                </div>
                <div className="flex justify-between items-center">
                  <span className="text-gray-600">Items Sold This Month</span>
                  <span className="font-medium text-gray-900">18</span>
                </div>
                <div className="flex justify-between items-center">
                  <span className="text-gray-600">Response Time</span>
                  <span className="font-medium text-green-600">1.2 hours</span>
                </div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Category Performance</h4>
              <div className="space-y-3">
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">Wedding Dresses</span>
                  <div className="flex items-center space-x-2">
                    <div className="w-20 bg-gray-200 rounded-full h-2">
                      <div className="bg-teal-500 h-2 rounded-full" style={{ width: '75%' }}></div>
                    </div>
                    <span className="text-sm font-medium">75%</span>
                  </div>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">Decorations</span>
                  <div className="flex items-center space-x-2">
                    <div className="w-20 bg-gray-200 rounded-full h-2">
                      <div className="bg-blue-500 h-2 rounded-full" style={{ width: '60%' }}></div>
                    </div>
                    <span className="text-sm font-medium">60%</span>
                  </div>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">Groom Attire</span>
                  <div className="flex items-center space-x-2">
                    <div className="w-20 bg-gray-200 rounded-full h-2">
                      <div className="bg-purple-500 h-2 rounded-full" style={{ width: '45%' }}></div>
                    </div>
                    <span className="text-sm font-medium">45%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'promotion' && (
        <div className="space-y-6">
          <h3 className="text-xl font-semibold text-gray-900">Promote Your Listings</h3>
          
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Featured Listings</h4>
              <p className="text-gray-600 mb-4">Get 3x more views by featuring your items at the top of search results.</p>
              <div className="space-y-3">
                <div className="flex justify-between items-center">
                  <span className="text-gray-600">Cost per item</span>
                  <span className="font-medium text-gray-900">R50/week</span>
                </div>
                <div className="flex justify-between items-center">
                  <span className="text-gray-600">Average increase in views</span>
                  <span className="font-medium text-green-600">+300%</span>
                </div>
              </div>
              <button className="w-full bg-yellow-500 text-white py-3 rounded-lg font-medium hover:bg-yellow-600 transition-colors mt-4">
                <Crown className="h-4 w-4 inline mr-2" />
                Feature Items
              </button>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Social Media Boost</h4>
              <p className="text-gray-600 mb-4">Share your items across our social media channels to reach more buyers.</p>
              <div className="space-y-3">
                <div className="flex justify-between items-center">
                  <span className="text-gray-600">Cost per item</span>
                  <span className="font-medium text-gray-900">R25/post</span>
                </div>
                <div className="flex justify-between items-center">
                  <span className="text-gray-600">Reach</span>
                  <span className="font-medium text-blue-600">10K+ followers</span>
                </div>
              </div>
              <button className="w-full bg-blue-500 text-white py-3 rounded-lg font-medium hover:bg-blue-600 transition-colors mt-4">
                <Share className="h-4 w-4 inline mr-2" />
                Boost on Social
              </button>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'profile' && (
        <div className="space-y-6">
          <h3 className="text-xl font-semibold text-gray-900">Seller Profile</h3>
          
          <div className="bg-white rounded-xl p-6 shadow-sm">
            <div className="flex items-center space-x-4 mb-6">
              <div className="w-20 h-20 bg-teal-100 rounded-full flex items-center justify-center">
                <Users className="h-10 w-10 text-teal-600" />
              </div>
              <div>
                <h4 className="text-xl font-semibold text-gray-900">{userName}</h4>
                <div className="flex items-center space-x-2 mt-1">
                  <Star className="h-4 w-4 text-yellow-500 fill-current" />
                  <span className="text-sm text-gray-600">4.8 (24 reviews)</span>
                  <Award className="h-4 w-4 text-blue-500 ml-2" />
                  <span className="text-sm text-blue-600">Verified Seller</span>
                </div>
              </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Store Name</label>
                <input
                  type="text"
                  defaultValue="Sarah's Wedding Treasures"
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Location</label>
                <input
                  type="text"
                  defaultValue="Cape Town, Western Cape"
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
                />
              </div>
            </div>

            <div className="mt-6">
              <label className="block text-sm font-medium text-gray-700 mb-2">Store Description</label>
              <textarea
                rows={4}
                defaultValue="Welcome to my collection of beautiful pre-loved wedding items! Each piece has been carefully selected and is in excellent condition. I believe every bride deserves to feel special on her big day, and these treasures can help make that happen at an affordable price."
                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
              />
            </div>

            <button className="bg-teal-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-teal-600 transition-colors mt-6">
              Update Profile
            </button>
          </div>
        </div>
      )}

      {selectedTab === 'settings' && (
        <div className="space-y-6">
          <h3 className="text-xl font-semibold text-gray-900">Account Settings</h3>
          
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Notifications</h4>
              <div className="space-y-4">
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-700">New Inquiries</span>
                  <button className="w-12 h-6 bg-teal-500 rounded-full relative">
                    <div className="w-5 h-5 bg-white rounded-full absolute right-0.5 top-0.5"></div>
                  </button>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-700">Sale Notifications</span>
                  <button className="w-12 h-6 bg-teal-500 rounded-full relative">
                    <div className="w-5 h-5 bg-white rounded-full absolute right-0.5 top-0.5"></div>
                  </button>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-700">Marketing Updates</span>
                  <button className="w-12 h-6 bg-gray-300 rounded-full relative">
                    <div className="w-5 h-5 bg-white rounded-full absolute left-0.5 top-0.5"></div>
                  </button>
                </div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Payment Settings</h4>
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Bank Account</label>
                  <input
                    type="text"
                    defaultValue="****1234"
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Payout Schedule</label>
                  <select className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500">
                    <option>Weekly</option>
                    <option>Bi-weekly</option>
                    <option>Monthly</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Add Item Modal */}
      {showAddItemModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div className="p-6">
              <div className="flex justify-between items-center mb-6">
                <h3 className="text-xl font-bold text-gray-900">Add New Item</h3>
                <button
                  onClick={() => setShowAddItemModal(false)}
                  className="p-2 hover:bg-gray-100 rounded-full transition-colors"
                >
                  <X className="h-5 w-5 text-gray-500" />
                </button>
              </div>

              <form className="space-y-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Item Title</label>
                    <input
                      type="text"
                      placeholder="e.g., Vintage Lace Wedding Dress"
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500">
                      {categories.slice(1).map(cat => (
                        <option key={cat} value={cat}>{cat}</option>
                      ))}
                    </select>
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Price (R)</label>
                    <input
                      type="number"
                      placeholder="2500"
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Original Price (R)</label>
                    <input
                      type="number"
                      placeholder="8000"
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                    <select className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500">
                      {conditions.map(condition => (
                        <option key={condition} value={condition}>{condition}</option>
                      ))}
                    </select>
                  </div>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Description</label>
                  <textarea
                    rows={4}
                    placeholder="Describe your item in detail..."
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
                  />
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Photos</label>
                  <div className="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-teal-400 transition-colors cursor-pointer">
                    <Upload className="h-8 w-8 text-gray-400 mx-auto mb-2" />
                    <p className="text-sm text-gray-600">Click to upload photos or drag and drop</p>
                    <p className="text-xs text-gray-500 mt-1">Up to 10 photos, max 5MB each</p>
                  </div>
                </div>

                <div className="flex space-x-3 pt-4">
                  <button
                    type="button"
                    onClick={() => setShowAddItemModal(false)}
                    className="flex-1 border border-gray-300 text-gray-700 py-3 rounded-xl font-medium hover:bg-gray-50 transition-colors"
                  >
                    Cancel
                  </button>
                  <button
                    type="submit"
                    className="flex-1 bg-gradient-to-r from-teal-500 to-cyan-600 text-white py-3 rounded-xl font-medium hover:from-teal-600 hover:to-cyan-700 transition-all duration-200"
                  >
                    Add Item
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}

      {/* Inquiry Reply Modal */}
      {showInquiryModal && selectedInquiry && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div className="p-6">
              <div className="flex justify-between items-center mb-6">
                <h3 className="text-xl font-bold text-gray-900">Reply to Inquiry</h3>
                <button
                  onClick={() => setShowInquiryModal(false)}
                  className="p-2 hover:bg-gray-100 rounded-full transition-colors"
                >
                  <X className="h-5 w-5 text-gray-500" />
                </button>
              </div>

              <div className="space-y-4 mb-6">
                <div className="bg-gray-50 p-4 rounded-lg">
                  <h4 className="font-medium text-gray-900 mb-2">Original Message</h4>
                  <p className="text-gray-700">{selectedInquiry.message}</p>
                  <div className="flex items-center justify-between mt-3 text-sm text-gray-500">
                    <span>From: {selectedInquiry.buyerName}</span>
                    <span>{selectedInquiry.date}</span>
                  </div>
                </div>

                {selectedInquiry.offer && (
                  <div className="bg-yellow-50 p-4 rounded-lg">
                    <h4 className="font-medium text-yellow-800 mb-2">Offer Received</h4>
                    <p className="text-yellow-700">R{selectedInquiry.offer.toLocaleString()}</p>
                  </div>
                )}
              </div>

              <form className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Your Reply</label>
                  <textarea
                    rows={6}
                    placeholder="Type your reply here..."
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500"
                  />
                </div>

                <div className="flex space-x-3">
                  <button
                    type="button"
                    onClick={() => setShowInquiryModal(false)}
                    className="flex-1 border border-gray-300 text-gray-700 py-3 rounded-xl font-medium hover:bg-gray-50 transition-colors"
                  >
                    Cancel
                  </button>
                  <button
                    type="submit"
                    className="flex-1 bg-gradient-to-r from-teal-500 to-cyan-600 text-white py-3 rounded-xl font-medium hover:from-teal-600 hover:to-cyan-700 transition-all duration-200"
                  >
                    Send Reply
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default SellerDashboard;
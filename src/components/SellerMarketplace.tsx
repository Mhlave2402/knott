import React, { useState, useRef } from 'react';
import { ShoppingBag, Search, Filter, Star, MapPin, Heart, Tag, ChevronLeft, ChevronRight } from 'lucide-react';

interface SellerItem {
  id: string;
  title: string;
  description: string;
  price: number;
  originalPrice?: number;
  category: string;
  condition: string;
  seller: string;
  location: string;
  image: string;
  rating: number;
  reviews: number;
  featured: boolean;
}

const mockItems: SellerItem[] = [
  {
    id: '1',
    title: 'Vintage Lace Wedding Dress',
    description: 'Beautiful vintage lace wedding dress, size 10, worn once. Includes veil and accessories.',
    price: 2500,
    originalPrice: 8000,
    category: 'Wedding Dress',
    condition: 'Excellent',
    seller: 'Sarah M.',
    location: 'Cape Town, Western Cape',
    image: 'https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=600',
    rating: 4.9,
    reviews: 12,
    featured: true
  },
  {
    id: '2',
    title: 'Crystal Centerpieces Set',
    description: 'Set of 8 elegant crystal centerpieces with LED lights. Perfect for reception tables.',
    price: 800,
    originalPrice: 2400,
    category: 'Decorations',
    condition: 'Like New',
    seller: 'Emma K.',
    location: 'Johannesburg, Gauteng',
    image: 'https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=600',
    rating: 4.8,
    reviews: 8,
    featured: false
  },
  {
    id: '3',
    title: 'Diamond Engagement Ring',
    description: '1.2 carat diamond engagement ring, 14k white gold setting. Certified and appraised.',
    price: 15000,
    originalPrice: 25000,
    category: 'Jewelry',
    condition: 'Excellent',
    seller: 'Michael R.',
    location: 'Durban, KwaZulu-Natal',
    image: 'https://images.pexels.com/photos/1024996/pexels-photo-1024996.jpeg?auto=compress&cs=tinysrgb&w=600',
    rating: 5.0,
    reviews: 5,
    featured: true
  },
  {
    id: '4',
    title: 'Wedding Arch with Flowers',
    description: 'Rustic wooden wedding arch decorated with artificial flowers. Easy to assemble.',
    price: 1200,
    originalPrice: 3500,
    category: 'Decorations',
    condition: 'Good',
    seller: 'Lisa T.',
    location: 'Pretoria, Gauteng',
    image: 'https://images.pexels.com/photos/1190297/pexels-photo-1190297.jpeg?auto=compress&cs=tinysrgb&w=600',
    rating: 4.7,
    reviews: 15,
    featured: false
  }
];

const conditions = ['All', 'Like New', 'Excellent', 'Good', 'Fair'];

const SellerMarketplace: React.FC = () => {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedProvince, setSelectedProvince] = useState('All');
  const [selectedCondition, setSelectedCondition] = useState('All');
  const [showFilters, setShowFilters] = useState(false);

  const scrollRef = useRef<HTMLDivElement>(null);

  // Extract provinces dynamically
  const provinces = [
    'All',
    ...Array.from(new Set(mockItems.map(item => item.location.split(',')[1].trim())))
  ];

  const scroll = (direction: 'left' | 'right') => {
    if (scrollRef.current) {
      const scrollAmount = 360;
      scrollRef.current.scrollBy({
        left: direction === 'left' ? -scrollAmount : scrollAmount,
        behavior: 'smooth',
      });
    }
  };

  const filteredItems = mockItems.filter(item => {
    const matchesSearch = item.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                          item.description.toLowerCase().includes(searchTerm.toLowerCase());
    const province = item.location.split(',')[1].trim();
    const matchesProvince = selectedProvince === 'All' || province === selectedProvince;
    const matchesCondition = selectedCondition === 'All' || item.condition === selectedCondition;
    return matchesSearch && matchesProvince && matchesCondition;
  });

  return (
    <div className="bg-gradient-to-br from-teal-50 to-cyan-50 py-16" id="sellers">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-12">
          <div className="flex items-center justify-center space-x-2 mb-4">
            <ShoppingBag className="h-8 w-8 text-teal-600" />
            <h2 className="text-4xl font-bold text-gray-900">Pre-Loved Wedding Items</h2>
          </div>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Find beautiful pre-owned wedding items at amazing prices, or sell your own treasures to help other couples
          </p>
        </div>

        {/* Search & Province Filters */}
        <div className="bg-white rounded-2xl shadow-lg p-6 mb-8">
          <div className="flex flex-col md:flex-row gap-4 mb-4">
            <div className="relative flex-1">
              <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
              <input
                type="text"
                placeholder="Search for wedding items..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
              />
            </div>
            <button
              onClick={() => setShowFilters(!showFilters)}
              className="flex items-center space-x-2 px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors"
            >
              <Filter className="h-5 w-5" />
              <span>Filters</span>
            </button>
          </div>

          {/* Province Buttons */}
          <div className="flex flex-wrap gap-2 mb-4">
            {provinces.map(province => (
              <button
                key={province}
                onClick={() => setSelectedProvince(province)}
                className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ${
                  selectedProvince === province
                    ? 'bg-teal-500 text-white shadow-lg transform scale-105'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                }`}
              >
                {province}
              </button>
            ))}
          </div>

          {/* Condition Filters */}
          {showFilters && (
            <div className="border-t border-gray-200 pt-4">
              <h4 className="text-sm font-medium text-gray-700 mb-2">Condition</h4>
              <div className="flex flex-wrap gap-2">
                {conditions.map(condition => (
                  <button
                    key={condition}
                    onClick={() => setSelectedCondition(condition)}
                    className={`px-3 py-1 rounded-full text-sm transition-all duration-200 ${
                      selectedCondition === condition
                        ? 'bg-cyan-500 text-white'
                        : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                    }`}
                  >
                    {condition}
                  </button>
                ))}
              </div>
            </div>
          )}
        </div>

        {/* Horizontal Scrollable Items */}
        <div className="relative">
          <button
            onClick={() => scroll('left')}
            className="absolute -left-6 top-1/2 transform -translate-y-1/2 bg-white shadow-lg p-2 rounded-full z-10 hover:bg-gray-100"
          >
            <ChevronLeft className="h-6 w-6 text-gray-700" />
          </button>

          <div
            ref={scrollRef}
            className="flex overflow-x-auto gap-6 scrollbar-hide scroll-smooth pb-4"
          >
            {filteredItems.map(item => {
              const savings = item.originalPrice ? ((item.originalPrice - item.price) / item.originalPrice * 100) : 0;
              return (
                <div
                  key={item.id}
                  className={`bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex-shrink-0 w-80 ${
                    item.featured ? 'ring-2 ring-teal-400' : ''
                  }`}
                >
                  {item.featured && (
                    <div className="bg-gradient-to-r from-teal-400 to-cyan-500 text-white text-center py-2 font-semibold text-sm">
                      Featured Item
                    </div>
                  )}

                  <div className="relative">
                    <img src={item.image} alt={item.title} className="w-full h-48 object-cover" />
                    {item.originalPrice && (
                      <div className="absolute top-3 right-3 bg-green-500 text-white px-2 py-1 rounded-full">
                        <span className="text-xs font-bold">{Math.round(savings)}% OFF</span>
                      </div>
                    )}
                  </div>

                  <div className="p-6">
                    <h3 className="text-lg font-semibold text-gray-900 mb-2">{item.title}</h3>
                    <p className="text-gray-600 text-sm mb-4 line-clamp-2">{item.description}</p>

                    <div className="space-y-3 mb-4">
                      <div className="flex items-center justify-between">
                        <div className="flex items-center space-x-2">
                          <span className="text-2xl font-bold text-teal-600">R{item.price.toLocaleString()}</span>
                          {item.originalPrice && (
                            <span className="text-sm text-gray-500 line-through">R{item.originalPrice.toLocaleString()}</span>
                          )}
                        </div>
                        <div className="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg">
                          <Star className="h-4 w-4 text-yellow-500 fill-current" />
                          <span className="text-sm font-semibold text-gray-700">{item.rating}</span>
                          <span className="text-xs text-gray-500">({item.reviews})</span>
                        </div>
                      </div>

                      <div className="flex items-center justify-between text-sm text-gray-500">
                        <div className="flex items-center space-x-1">
                          <MapPin className="h-4 w-4" />
                          <span>{item.location}</span>
                        </div>
                        <div className="flex items-center space-x-1">
                          <Tag className="h-4 w-4" />
                          <span>{item.condition}</span>
                        </div>
                      </div>

                      <div className="text-sm text-gray-600">
                        Sold by <span className="font-medium">{item.seller}</span>
                      </div>
                    </div>

                    <div className="flex space-x-3">
                      <button className="flex-1 bg-gradient-to-r from-teal-500 to-cyan-600 text-white py-2 rounded-xl font-medium hover:from-teal-600 hover:to-cyan-700 transition-all duration-200">
                        View Details
                      </button>
                      <button className="flex-1 border border-teal-300 text-teal-600 py-2 rounded-xl font-medium hover:bg-teal-50 transition-colors flex items-center justify-center space-x-1">
                        <Heart className="h-4 w-4" />
                        <span>Save</span>
                      </button>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>

          <button
            onClick={() => scroll('right')}
            className="absolute -right-6 top-1/2 transform -translate-y-1/2 bg-white shadow-lg p-2 rounded-full z-10 hover:bg-gray-100"
          >
            <ChevronRight className="h-6 w-6 text-gray-700" />
          </button>
        </div>
      </div>
    </div>
  );
};

export default SellerMarketplace;

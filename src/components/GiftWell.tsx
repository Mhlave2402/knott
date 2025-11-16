import React, { useState, useRef, useEffect } from 'react';
import { Gift, Users, Heart, Search, Filter, MapPin, Calendar, ChevronLeft, ChevronRight } from 'lucide-react';
import { GiftWellItem } from '../types';

interface CoupleRegistry {
  id: string;
  coupleName: string;
  weddingDate: string;
  location: string;
  totalGoal: number;
  totalRaised: number;
  contributors: number;
  image: string;
  items: GiftWellItem[];
  featured: boolean;
}

interface GiftItem {
  id: string;
  title: string;
  description: string;
  targetAmount: number;
  category: string;
  image?: string;
}

const mockCoupleRegistries: CoupleRegistry[] = [
  {
    id: '1',
    coupleName: 'Sarah & Michael',
    weddingDate: 'June 15, 2024',
    location: 'Cape Town, Western Cape',
    totalGoal: 50000,
    totalRaised: 32500,
    contributors: 45,
    image: 'https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=400',
    items: [],
    featured: true
  },
  {
    id: '2',
    coupleName: 'Emma & David',
    weddingDate: 'August 22, 2024',
    location: 'Johannesburg, Gauteng',
    totalGoal: 75000,
    totalRaised: 28000,
    contributors: 32,
    image: 'https://images.pexels.com/photos/1043473/pexels-photo-1043473.jpeg?auto=compress&cs=tinysrgb&w=400',
    items: [],
    featured: false
  },
  {
    id: '3',
    coupleName: 'Lisa & James',
    weddingDate: 'September 10, 2024',
    location: 'Durban, KwaZulu-Natal',
    totalGoal: 60000,
    totalRaised: 55000,
    contributors: 67,
    image: 'https://images.pexels.com/photos/1444442/pexels-photo-1444442.jpeg?auto=compress&cs=tinysrgb&w=400',
    items: [],
    featured: true
  },
  {
    id: '4',
    coupleName: 'Rachel & Tom',
    weddingDate: 'October 5, 2024',
    location: 'Pretoria, Gauteng',
    totalGoal: 40000,
    totalRaised: 15000,
    contributors: 23,
    image: 'https://images.pexels.com/photos/1024960/pexels-photo-1024960.jpeg?auto=compress&cs=tinysrgb&w=400',
    items: [],
    featured: false
  },
  {
    id: '5',
    coupleName: 'Amy & Chris',
    weddingDate: 'November 18, 2024',
    location: 'Port Elizabeth, Eastern Cape',
    totalGoal: 55000,
    totalRaised: 42000,
    contributors: 38,
    image: 'https://images.pexels.com/photos/1043474/pexels-photo-1043474.jpeg?auto=compress&cs=tinysrgb&w=400',
    items: [],
    featured: false
  },
  {
    id: '6',
    coupleName: 'Jessica & Ryan',
    weddingDate: 'December 12, 2024',
    location: 'Bloemfontein, Free State',
    totalGoal: 45000,
    totalRaised: 38000,
    contributors: 51,
    image: 'https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=400',
    items: [],
    featured: true
  },
  {
    id: '7',
    coupleName: 'Nicole & Mark',
    weddingDate: 'January 20, 2025',
    location: 'Stellenbosch, Western Cape',
    totalGoal: 65000,
    totalRaised: 22000,
    contributors: 29,
    image: 'https://images.pexels.com/photos/1024992/pexels-photo-1024992.jpeg?auto=compress&cs=tinysrgb&w=400',
    items: [],
    featured: false
  },
  {
    id: '8',
    coupleName: 'Hannah & Luke',
    weddingDate: 'February 14, 2025',
    location: 'Nelspruit, Mpumalanga',
    totalGoal: 50000,
    totalRaised: 47000,
    contributors: 62,
    image: 'https://images.pexels.com/photos/1043475/pexels-photo-1043475.jpeg?auto=compress&cs=tinysrgb&w=400',
    items: [],
    featured: false
  }
];

const GiftWell: React.FC = () => {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedLocation, setSelectedLocation] = useState('All');
  const [showFilters, setShowFilters] = useState(false);

  const carouselRef = useRef<HTMLDivElement>(null);
  const itemsPerScroll = 1;

  const locations = [
    'All',
    ...Array.from(new Set(mockCoupleRegistries.map(couple => couple.location.split(',')[1].trim())))
  ];

  const filteredRegistries = mockCoupleRegistries.filter(couple => {
    const matchesSearch =
      couple.coupleName.toLowerCase().includes(searchTerm.toLowerCase()) ||
      couple.location.toLowerCase().includes(searchTerm.toLowerCase());
    const location = couple.location.split(',')[1].trim();
    const matchesLocation = selectedLocation === 'All' || location === selectedLocation;
    return matchesSearch && matchesLocation;
  });

  useEffect(() => {
    if (carouselRef.current) carouselRef.current.scrollLeft = 0;
  }, [searchTerm, selectedLocation]);

  const scrollLeft = () => {
    if (carouselRef.current) {
      const cardWidth = carouselRef.current.firstElementChild?.clientWidth || 0;
      carouselRef.current.scrollBy({ left: -cardWidth * itemsPerScroll, behavior: 'smooth' });
    }
  };

  const scrollRight = () => {
    if (carouselRef.current) {
      const cardWidth = carouselRef.current.firstElementChild?.clientWidth || 0;
      carouselRef.current.scrollBy({ left: cardWidth * itemsPerScroll, behavior: 'smooth' });
    }
  };

  return (
    <div className="bg-gradient-to-br from-pink-50 to-purple-50 py-16">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {/* Header */}
        <div className="text-center mb-12">
          <div className="flex items-center justify-center space-x-2 mb-4">
            <Gift className="h-8 w-8 text-pink-600" />
            <h2 className="text-4xl font-bold text-gray-900">Gift Well Directory</h2>
          </div>
          <p className="text-xl text-gray-600 max-w-2xl mx-auto">
            Discover couples' gift registries and contribute to their special day
          </p>
        </div>

        {/* Search & Filters */}
        <div className="bg-white rounded-2xl shadow-lg p-6 mb-8">
          <div className="flex flex-col md:flex-row gap-4 mb-4">
            <div className="relative flex-1">
              <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
              <input
                type="text"
                placeholder="Search couples or locations..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
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

          {/* Location Filters */}
          <div className="flex flex-wrap gap-2">
            {locations.map(location => (
              <button
                key={location}
                onClick={() => setSelectedLocation(location)}
                className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ${
                  selectedLocation === location
                    ? 'bg-pink-500 text-white shadow-lg transform scale-105'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                }`}
              >
                {location}
              </button>
            ))}
          </div>
        </div>

        {/* Cards - Airbnb-style horizontal scroll */}
        <div className="relative">
          {/* Left Arrow */}
          <button
            onClick={scrollLeft}
            className="absolute left-0 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-100 p-3 rounded-full shadow-md z-10 transition"
          >
            <ChevronLeft className="h-6 w-6 text-gray-700" />
          </button>

          <div
            ref={carouselRef}
            className="flex overflow-x-auto gap-6 scrollbar-hide scroll-smooth pb-4"
          >
            {filteredRegistries.map((couple) => {
              const progress = (couple.totalRaised / couple.totalGoal) * 100;
              return (
                <div
                  key={couple.id}
                  className={`min-w-[300px] bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 ${
                    couple.featured ? 'ring-2 ring-pink-400' : ''
                  }`}
                >
                  {couple.featured && (
                    <div className="bg-gradient-to-r from-pink-400 to-purple-500 text-white text-center py-2 font-semibold text-sm">
                      Featured Couple
                    </div>
                  )}
                  <div className="relative">
                    <img
                      src={couple.image}
                      alt={couple.coupleName}
                      className="w-full h-40 object-cover"
                    />
                    <div className="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full">
                      <span className="text-xs font-medium text-gray-700">
                        {Math.round(progress)}% funded
                      </span>
                    </div>
                  </div>
                  <div className="p-6">
                    <h3 className="text-lg font-semibold text-gray-900 mb-1">{couple.coupleName}</h3>
                    <div className="flex items-center text-sm text-gray-500 mb-1">
                      <Calendar className="h-4 w-4 mr-1" /> {couple.weddingDate}
                    </div>
                    <div className="flex items-center text-sm text-gray-500 mb-3">
                      <MapPin className="h-4 w-4 mr-1" /> {couple.location}
                    </div>
                    <div className="space-y-3">
                      <div className="flex justify-between text-sm">
                        <span className="text-gray-600">Total Progress</span>
                        <span className="font-medium text-gray-900">
                          R{couple.totalRaised.toLocaleString()} of R{couple.totalGoal.toLocaleString()}
                        </span>
                      </div>
                      <div className="w-full bg-gray-200 rounded-full h-2">
                        <div
                          className="bg-gradient-to-r from-pink-500 to-purple-600 h-2 rounded-full transition-all duration-500"
                          style={{ width: `${Math.min(progress, 100)}%` }}
                        ></div>
                      </div>
                      <div className="flex items-center justify-between text-sm text-gray-500">
                        <div className="flex items-center space-x-1">
                          <Users className="h-4 w-4" /> <span>{couple.contributors} contributors</span>
                        </div>
                        <span>{Math.round(progress)}% complete</span>
                      </div>
                    </div>
                    <div className="flex space-x-3 mt-6">
                      <button className="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white py-2 rounded-xl font-medium hover:from-pink-600 hover:to-purple-700 transition-all duration-200">
                        View Registry
                      </button>
                      <button className="flex-1 border border-pink-300 text-pink-600 py-2 rounded-xl font-medium hover:bg-pink-50 transition-colors flex items-center justify-center space-x-1">
                        <Heart className="h-4 w-4" /> <span>Contribute</span>
                      </button>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>

          {/* Right Arrow */}
          <button
            onClick={scrollRight}
            className="absolute right-0 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-100 p-3 rounded-full shadow-md z-10 transition"
          >
            <ChevronRight className="h-6 w-6 text-gray-700" />
          </button>
        </div>
      </div>
    </div>
  );
};

export default GiftWell;

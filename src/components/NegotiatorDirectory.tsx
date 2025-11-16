import React, { useRef, useState, useEffect } from 'react';
import { Users, Star, MapPin, Award, Clock, Search, ChevronLeft, ChevronRight } from 'lucide-react';
import { Negotiator } from '../types';

const mockNegotiators: Negotiator[] = [
  {
    id: '1',
    name: 'Themba Mthembu',
    experience: '15+ years',
    location: 'Johannesburg, Gauteng',
    specialties: ['Zulu Traditions', 'Lobola Negotiations', 'Wedding Ceremonies'],
    rating: 4.9,
    reviews: 89,
    image: 'https://images.pexels.com/photos/1043471/pexels-photo-1043471.jpeg?auto=compress&cs=tinysrgb&w=400',
    verified: true,
    hourlyRate: 'R800/hour'
  },
  {
    id: '2',
    name: 'Nomsa Khumalo',
    experience: '12+ years',
    location: 'Durban, KwaZulu-Natal',
    specialties: ['Traditional Ceremonies', 'Cultural Guidance', 'Family Mediation'],
    rating: 4.8,
    reviews: 134,
    image: 'https://images.pexels.com/photos/1043473/pexels-photo-1043473.jpeg?auto=compress&cs=tinysrgb&w=400',
    verified: true,
    hourlyRate: 'R750/hour'
  },
  {
    id: '3',
    name: 'Samuel Mokone',
    experience: '20+ years',
    location: 'Pretoria, Gauteng',
    specialties: ['Sotho Traditions', 'Marriage Negotiations', 'Cultural Education'],
    rating: 5.0,
    reviews: 67,
    image: 'https://images.pexels.com/photos/1043471/pexels-photo-1043471.jpeg?auto=compress&cs=tinysrgb&w=400',
    verified: true,
    hourlyRate: 'R900/hour'
  }
];

const NegotiatorDirectory: React.FC = () => {
  const scrollRef = useRef<HTMLDivElement>(null);
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedProvince, setSelectedProvince] = useState('All');

  // Extract provinces dynamically from mockNegotiators
  const provinces = [
    'All',
    ...Array.from(
      new Set(mockNegotiators.map(n => n.location.split(',')[1].trim()))
    )
  ];

  const scroll = (direction: 'left' | 'right') => {
    if (scrollRef.current) {
      const scrollAmount = 320; // card width + gap
      scrollRef.current.scrollBy({
        left: direction === 'left' ? -scrollAmount : scrollAmount,
        behavior: 'smooth',
      });
    }
  };

  // Filter negotiators by search + selectedProvince
  const filteredNegotiators = mockNegotiators.filter((negotiator) => {
    const matchesSearch =
      negotiator.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      negotiator.location.toLowerCase().includes(searchTerm.toLowerCase()) ||
      negotiator.specialties.some(s => s.toLowerCase().includes(searchTerm.toLowerCase()));

    const province = negotiator.location.split(',')[1].trim();
    const matchesProvince = selectedProvince === 'All' || province === selectedProvince;

    return matchesSearch && matchesProvince;
  });

  return (
    <div className="bg-white py-16" id="negotiators">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-12">
          <h2 className="text-4xl font-bold text-gray-900 mb-4">
            Traditional Wedding Negotiators
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Connect with experienced Bomalume who honor traditional customs and guide families through cultural ceremonies
          </p>
        </div>

        {/* Search & Province Filters */}
        <div className="bg-gray-50 rounded-2xl shadow-inner p-6 mb-8">
          <div className="flex flex-col md:flex-row gap-4 mb-4">
            <div className="relative flex-1">
              <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
              <input
                type="text"
                placeholder="Search negotiators by name or location..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
              />
            </div>
          </div>

          {/* Province Filters */}
          <div className="flex flex-wrap gap-2">
            {provinces.map(province => (
              <button
                key={province}
                onClick={() => setSelectedProvince(province)}
                className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ${
                  selectedProvince === province
                    ? 'bg-purple-500 text-white shadow-lg transform scale-105'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                }`}
              >
                {province}
              </button>
            ))}
          </div>
        </div>

        {/* Carousel */}
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
            {filteredNegotiators.map(n => (
              <div key={n.id} className="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden flex-shrink-0 w-80">
                <div className="relative">
                  <img src={n.image} alt={n.name} className="w-full h-48 object-cover" />
                  {n.verified && (
                    <div className="absolute top-3 right-3 bg-blue-500 text-white p-2 rounded-full">
                      <Award className="h-4 w-4" />
                    </div>
                  )}
                </div>

                <div className="p-6">
                  <div className="flex justify-between items-start mb-3">
                    <div>
                      <h3 className="text-lg font-semibold text-gray-900 mb-1">{n.name}</h3>
                      <div className="flex items-center text-sm text-gray-500">
                        <Clock className="h-4 w-4 mr-1" />
                        {n.experience}
                      </div>
                    </div>
                    <div className="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg">
                      <Star className="h-4 w-4 text-yellow-500 fill-current" />
                      <span className="text-sm font-semibold text-gray-700">{n.rating}</span>
                      <span className="text-xs text-gray-500">({n.reviews})</span>
                    </div>
                  </div>

                  <div className="space-y-3 mb-4">
                    <div className="flex items-center text-sm text-gray-500">
                      <MapPin className="h-4 w-4 mr-2 flex-shrink-0" />
                      {n.location}
                    </div>
                    <div className="text-sm font-medium text-purple-700">{n.hourlyRate}</div>
                  </div>

                  {/* Specialties */}
                  <div className="mb-6">
                    <h4 className="text-sm font-medium text-gray-700 mb-2">Specialties</h4>
                    <div className="flex flex-wrap gap-1">
                      {n.specialties.map((s, idx) => (
                        <span key={idx} className="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs font-medium">{s}</span>
                      ))}
                    </div>
                  </div>

                  <div className="flex space-x-3">
                    <button className="flex-1 bg-gradient-to-r from-purple-500 to-pink-600 text-white py-2 rounded-xl font-medium hover:from-purple-600 hover:to-pink-700 transition-all duration-200">
                      View Profile
                    </button>
                    <button className="flex-1 border border-purple-300 text-purple-600 py-2 rounded-xl font-medium hover:bg-purple-50 transition-colors">
                      Book Consultation
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>

          <button
            onClick={() => scroll('right')}
            className="absolute -right-6 top-1/2 transform -translate-y-1/2 bg-white shadow-lg p-2 rounded-full z-10 hover:bg-gray-100"
          >
            <ChevronRight className="h-6 w-6 text-gray-700" />
          </button>
        </div>

        {/* Cultural Info */}
        <div className="mt-16 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 text-white">
          <div className="max-w-4xl mx-auto text-center">
            <Users className="h-12 w-12 mx-auto mb-4 opacity-90" />
            <h3 className="text-2xl font-bold mb-4">Understanding Traditional Negotiations</h3>
            <p className="text-purple-100 mb-6 leading-relaxed">
              Our experienced negotiators respect and honor cultural traditions while facilitating meaningful 
              conversations between families. They provide guidance on lobola negotiations, ceremony planning, 
              and ensuring cultural protocols are properly observed.
            </p>
            <button className="bg-white text-purple-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors">
              Learn More About Our Process
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default NegotiatorDirectory;

import React, { useState } from 'react';
import { Search, Star, MapPin, Users, Award, Crown, Music, Car, Utensils, ChevronLeft, ChevronRight } from 'lucide-react';
import { Venue } from '../types';

export const mockVenues: Venue[] = [
  {
    id: '1',
    name: 'Riverside Garden Estate',
    location: 'Stellenbosch, Western Cape',
    capacity: '80-150 guests',
    priceRange: 'R25,000 - R45,000',
    rating: 4.9,
    reviews: 156,
    image: 'https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=600',
    amenities: ['Garden Setting', 'Bridal Suite', 'Parking', 'Catering Kitchen'],
    verified: true,
    premium: true
  },
  {
    id: '2',
    name: 'Mountain View Manor',
    location: 'Cape Town, Western Cape',
    capacity: '120-250 guests',
    priceRange: 'R35,000 - R65,000',
    rating: 4.8,
    reviews: 203,
    image: 'https://images.pexels.com/photos/1024996/pexels-photo-1024996.jpeg?auto=compress&cs=tinysrgb&w=600',
    amenities: ['Mountain Views', 'Indoor/Outdoor', 'Sound System', 'Security'],
    verified: true,
    premium: false
  },
  {
    id: '3',
    name: 'Historic Heritage Hall',
    location: 'Johannesburg, Gauteng',
    capacity: '200-400 guests',
    priceRange: 'R30,000 - R55,000',
    rating: 4.7,
    reviews: 89,
    image: 'https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=600',
    amenities: ['Historic Architecture', 'Grand Ballroom', 'Valet Parking', 'Full Bar'],
    verified: true,
    premium: true
  }
];

const amenityIcons: Record<string, any> = {
  'Garden Setting': '🌿',
  'Bridal Suite': '👰',
  'Parking': Car,
  'Catering Kitchen': Utensils,
  'Mountain Views': '🏔️',
  'Indoor/Outdoor': '🏠',
  'Sound System': Music,
  'Security': '🛡️',
  'Historic Architecture': '🏛️',
  'Grand Ballroom': '💃',
  'Valet Parking': Car,
  'Full Bar': '🍸'
};

const VenueDirectory: React.FC = () => {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedFilter, setSelectedFilter] = useState('All');

  // Extract unique provinces dynamically from venue locations
  const provinces = [
    'All',
    ...Array.from(new Set(mockVenues.map(v => v.location.split(',')[1].trim())))
  ];

  // Filter options include premium, verified, and dynamic provinces
  const filters = ['All', 'Premium', 'Verified', ...provinces.slice(1)];

  const filteredVenues = mockVenues.filter(venue => {
    const matchesSearch =
      venue.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      venue.location.toLowerCase().includes(searchTerm.toLowerCase());

    const matchesFilter =
      selectedFilter === 'All' ||
      (selectedFilter === 'Premium' && venue.premium) ||
      (selectedFilter === 'Verified' && venue.verified) ||
      venue.location.includes(selectedFilter);

    return matchesSearch && matchesFilter;
  });

  return (
    <div className="bg-gray-50 py-16" id="venues">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {/* Header */}
        <div className="text-center mb-8">
          <h2 className="text-4xl font-bold text-gray-900 mb-2">
            Discover Perfect Wedding Venues
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Find stunning venues that match your vision, from intimate gardens to grand ballrooms
          </p>
        </div>

        {/* Search Bar */}
        <div className="bg-white rounded-2xl shadow-lg p-6 mb-4">
          <div className="relative flex-1">
            <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
            <input
              type="text"
              placeholder="Search venues by name or location..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>

        {/* Dynamic Filters */}
        <div className="flex flex-wrap gap-2 mb-6">
          {filters.map(f => (
            <button
              key={f}
              onClick={() => setSelectedFilter(f)}
              className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ${
                selectedFilter === f
                  ? 'bg-blue-600 text-white shadow-md transform scale-105'
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
              }`}
            >
              {f}
            </button>
          ))}
        </div>

        {/* Horizontal Scroll */}
        <div className="relative">
          <div className="flex overflow-x-auto space-x-6 scrollbar-hide snap-x snap-mandatory pb-4">
            {filteredVenues.map(venue => (
              <div
                key={venue.id}
                className="min-w-[320px] max-w-sm bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden group snap-start"
              >
                {/* Image */}
                <div className="relative">
                  <img
                    src={venue.image}
                    alt={venue.name}
                    className="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                  {venue.premium && (
                    <div className="absolute top-3 left-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center space-x-1">
                      <Crown className="h-3 w-3" />
                      <span>Premium</span>
                    </div>
                  )}
                  {venue.verified && (
                    <div className="absolute top-3 right-3 bg-blue-500 text-white p-2 rounded-full">
                      <Award className="h-4 w-4" />
                    </div>
                  )}
                </div>

                {/* Content */}
                <div className="p-6">
                  <div className="flex justify-between items-start mb-3">
                    <div>
                      <h3 className="text-lg font-semibold text-gray-900 mb-1">{venue.name}</h3>
                      <div className="flex items-center text-sm text-gray-500">
                        <MapPin className="h-4 w-4 mr-1" />
                        {venue.location}
                      </div>
                    </div>
                    <div className="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg">
                      <Star className="h-4 w-4 text-yellow-500 fill-current" />
                      <span className="text-sm font-semibold text-gray-700">{venue.rating}</span>
                      <span className="text-xs text-gray-500">({venue.reviews})</span>
                    </div>
                  </div>

                  {/* Capacity & Price */}
                  <div className="space-y-2 mb-4">
                    <div className="flex items-center text-sm text-gray-500">
                      <Users className="h-4 w-4 mr-2" />
                      {venue.capacity}
                    </div>
                    <div className="text-sm font-medium text-blue-700">{venue.priceRange}</div>
                  </div>

                  {/* Amenities */}
                  <div className="mb-6">
                    <h4 className="text-sm font-medium text-gray-700 mb-2">Amenities</h4>
                    <div className="flex flex-wrap gap-1">
                      {venue.amenities.slice(0, 3).map((amenity, idx) => {
                        const AmenityIcon = amenityIcons[amenity];
                        return (
                          <span
                            key={idx}
                            className="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-medium flex items-center space-x-1"
                          >
                            {typeof AmenityIcon === 'string' ? (
                              <span>{AmenityIcon}</span>
                            ) : AmenityIcon ? (
                              <AmenityIcon className="h-3 w-3" />
                            ) : null}
                            <span>{amenity}</span>
                          </span>
                        );
                      })}
                      {venue.amenities.length > 3 && (
                        <span className="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">
                          +{venue.amenities.length - 3} more
                        </span>
                      )}
                    </div>
                  </div>

                  {/* Buttons */}
                  <div className="flex space-x-3">
                    <button className="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-2 rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 transition-all duration-200">
                      View Details
                    </button>
                    <button className="flex-1 border border-blue-300 text-blue-600 py-2 rounded-xl font-medium hover:bg-blue-50 transition-colors">
                      Check Availability
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>

          {/* Scroll Buttons */}
          <button
            className="absolute top-1/2 -left-4 transform -translate-y-1/2 bg-white shadow-lg p-2 rounded-full hover:bg-gray-100"
            onClick={() => {
              const container = document.querySelector('.overflow-x-auto') as HTMLElement;
              if (container) container.scrollBy({ left: -350, behavior: 'smooth' });
            }}
          >
            <ChevronLeft className="h-5 w-5" />
          </button>
          <button
            className="absolute top-1/2 -right-4 transform -translate-y-1/2 bg-white shadow-lg p-2 rounded-full hover:bg-gray-100"
            onClick={() => {
              const container = document.querySelector('.overflow-x-auto') as HTMLElement;
              if (container) container.scrollBy({ left: 350, behavior: 'smooth' });
            }}
          >
            <ChevronRight className="h-5 w-5" />
          </button>
        </div>
      </div>
    </div>
  );
};

export default VenueDirectory;

import React, { useState, useRef } from 'react';
import {
  Search,
  Filter,
  Star,
  Crown,
} from 'lucide-react';
import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { mockPros } from './ProDirectory';
import { mockVenues } from './VenueDirectory';

interface MapViewProps {
  type: 'pros' | 'venues' | 'negotiators' | 'sellers';
}

const MapView: React.FC<MapViewProps> = ({ type }) => {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('All');
  const [showFilters, setShowFilters] = useState(false);
  const [selectedItem, setSelectedItem] = useState<string | null>(null);

  const markersRef = useRef<{ [key: string]: L.Marker }>({});

  const defaultIcon = new L.Icon({
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
  });

  const highlightIcon = new L.Icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
    iconSize: [35, 35],
    iconAnchor: [17, 35],
  });

  const getTitle = () => {
    switch (type) {
      case 'pros': return 'Wedding Pros in South Africa';
      case 'venues': return 'Wedding Venues in South Africa';
      case 'negotiators': return 'Traditional Negotiators in South Africa';
      case 'sellers': return 'Pre-Loved Wedding Items in South Africa';
      default: return 'Wedding Services in South Africa';
    }
  };

  const getSubtitle = () => {
    switch (type) {
      case 'pros': return 'Showing 1 - 18 of 1,200+ verified wedding professionals';
      case 'venues': return 'Showing 1 - 18 of 500+ beautiful wedding venues';
      case 'negotiators': return 'Showing 1 - 18 of 150+ experienced traditional negotiators';
      case 'sellers': return 'Showing 1 - 18 of 800+ pre-loved wedding items';
      default: return 'Showing available options';
    }
  };

  const getCategories = () => {
    switch (type) {
      case 'pros': return ['All', 'Photography', 'Florals', 'Entertainment', 'Catering', 'Videography', 'Makeup'];
      case 'venues': return ['All', 'Garden', 'Ballroom', 'Beach', 'Rustic', 'Modern', 'Historic'];
      case 'negotiators': return ['All', 'Zulu Traditions', 'Sotho Traditions', 'Xhosa Traditions', 'Lobola Negotiations'];
      case 'sellers': return ['All', 'Wedding Dress', 'Jewelry', 'Decorations', 'Shoes', 'Accessories'];
      default: return ['All'];
    }
  };

  const getData = () => {
    switch (type) {
      case 'pros': return mockPros;
      case 'venues': return mockVenues;
      case 'negotiators': return [
        {
          id: '1', name: 'Themba Mthembu', category: 'Traditional Negotiator',
          rating: 4.9, reviews: 89, location: 'Johannesburg, Gauteng',
          priceRange: 'R800/hour',
          lat: -26.2041, lng: 28.0473,
          image: 'https://images.pexels.com/photos/1043471/pexels-photo-1043471.jpeg?auto=compress&cs=tinysrgb&w=400',
          verified: true, premium: false,
          description: 'Experienced in Zulu traditions and lobola negotiations',
        },
        {
          id: '2', name: 'Nomsa Khumalo', category: 'Traditional Negotiator',
          rating: 4.8, reviews: 134, location: 'Durban, KwaZulu-Natal',
          priceRange: 'R750/hour',
          lat: -29.8587, lng: 31.0218,
          image: 'https://images.pexels.com/photos/1043473/pexels-photo-1043473.jpeg?auto=compress&cs=tinysrgb&w=400',
          verified: true, premium: true,
          description: 'Specializes in traditional ceremonies and cultural guidance',
        },
      ];
      case 'sellers': return [
        {
          id: '1', name: 'Vintage Lace Wedding Dress', category: 'Wedding Dress',
          rating: 4.9, reviews: 12, location: 'Cape Town, Western Cape',
          priceRange: 'R2,500',
          lat: -33.9249, lng: 18.4241,
          image: 'https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=400',
          verified: true, premium: false,
          description: 'Beautiful vintage lace dress, size 10, worn once',
        },
        {
          id: '2', name: 'Crystal Centerpieces Set', category: 'Decorations',
          rating: 4.8, reviews: 8, location: 'Johannesburg, Gauteng',
          priceRange: 'R800',
          lat: -26.2041, lng: 28.0473,
          image: 'https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=400',
          verified: true, premium: true,
          description: 'Set of 8 elegant crystal centerpieces with LED lights',
        },
      ];
      default: return [];
    }
  };

  const categories = getCategories();
  const data = getData();

  const filteredData = data.filter((item) => {
    const matchesSearch =
      item.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      item.location.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesCategory =
      selectedCategory === 'All' || item.category === selectedCategory;
    return matchesSearch && matchesCategory;
  });

  return (
    <div className="bg-gray-50">
      {/* Search Header */}
      <div className="bg-white border-b border-gray-200 sticky top-16 z-40">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div className="flex flex-col lg:flex-row gap-4">
            <div className="flex-1">
              <div className="relative">
                <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                <input
                  type="text"
                  placeholder={`Search ${type}...`}
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                />
              </div>
            </div>
            <div className="flex items-center space-x-4">
              <button
                onClick={() => setShowFilters(!showFilters)}
                className="flex items-center space-x-2 px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-50"
              >
                <Filter className="h-5 w-5" />
                <span>Filters</span>
              </button>
            </div>
          </div>
          <div className="mt-4 flex flex-wrap gap-2">
            {categories.map((category) => (
              <button
                key={category}
                onClick={() => setSelectedCategory(category)}
                className={`px-4 py-2 rounded-full text-sm font-medium ${
                  selectedCategory === category
                    ? 'bg-pink-500 text-white shadow-lg'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                }`}
              >
                {category}
              </button>
            ))}
          </div>
        </div>
      </div>

      {/* Main Layout */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        {/* Listings Section */}
        <div className="space-y-4 pb-10">
          <h1 className="text-2xl font-bold text-gray-900">{getTitle()}</h1>
          <p className="text-gray-600 mb-4">{getSubtitle()}</p>

          {filteredData.map((item) => (
            <div
              key={item.id}
              className={`bg-white rounded-2xl shadow hover:shadow-lg transition-all overflow-hidden border ${
                selectedItem === item.id ? 'border-pink-500' : 'border-gray-100'
              }`}
              onMouseEnter={() => {
                const m = markersRef.current[item.id];
                if (m) m.setIcon(highlightIcon);
              }}
              onMouseLeave={() => {
                const m = markersRef.current[item.id];
                if (m) m.setIcon(defaultIcon);
              }}
              onClick={() => setSelectedItem(item.id)}
            >
              <div className="flex">
                <div className="relative w-64 h-48 flex-shrink-0">
                  <img src={item.image} alt={item.name} className="w-full h-full object-cover" />
                  {item.premium && (
                    <div className="absolute top-3 left-3 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center space-x-1">
                      <Crown className="h-3 w-3" />
                      <span>Premium</span>
                    </div>
                  )}
                </div>
                <div className="flex-1 p-4">
                  <h3 className="text-lg font-semibold text-gray-900">{item.name}</h3>
                  <p className="text-pink-600 text-sm font-medium">{item.category}</p>
                  <div className="flex items-center space-x-1 mt-2">
                    <Star className="h-4 w-4 text-yellow-400" />
                    <span className="text-sm text-gray-700">{item.rating} ({item.reviews})</span>
                  </div>
                  <p className="text-sm text-gray-500 mt-2">{item.location}</p>
                  <p className="text-pink-600 font-semibold mt-2">{item.priceRange}</p>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Map Section */}
        <div className="h-[80vh] rounded-2xl overflow-hidden shadow">
          <MapContainer center={[-28.4793, 24.6727]} zoom={5} style={{ height: '100%', width: '100%' }}>
            <TileLayer
              attribution='&copy; OpenStreetMap'
              url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />
            {filteredData.map((item) => (
              <Marker
                key={item.id}
                position={[item.lat, item.lng]}
                icon={defaultIcon}
                ref={(ref) => {
                  if (ref) markersRef.current[item.id] = ref as unknown as L.Marker;
                }}
              >
                <Popup>
                  <strong>{item.name}</strong>
                  <br />
                  {item.location}
                </Popup>
              </Marker>
            ))}
          </MapContainer>
        </div>
      </div>
    </div>
  );
};

export default MapView;

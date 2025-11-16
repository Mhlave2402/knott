import React, { useState } from 'react';
import { 
  Calendar, 
  Gift, 
  Camera, 
  MessageCircle, 
  MapPin, 
  Clock, 
  Heart, 
  Star,
  CheckCircle,
  XCircle,
  AlertCircle,
  Plus,
  Search,
  Filter,
  Upload,
  ThumbsUp,
  Share2,
  Bookmark,
  Phone,
  Mail,
  Car,
  Bed,
  Wifi,
  Users,
  Baby,
  Utensils,
  Sun,
  Cloud
} from 'lucide-react';

interface GuestDashboardProps {
  userName: string;
}

const GuestDashboard: React.FC<GuestDashboardProps> = ({ userName }) => {
  const [activeTab, setActiveTab] = useState('overview');
  const [selectedEvent, setSelectedEvent] = useState<any>(null);
  const [selectedRSVP, setSelectedRSVP] = useState<any>(null);
  const [selectedGift, setSelectedGift] = useState<any>(null);
  const [searchTerm, setSearchTerm] = useState('');
  const [filterStatus, setFilterStatus] = useState('all');

  // Mock data
  const upcomingEvents = [
    {
      id: 1,
      coupleName: "Sarah & Michael",
      eventType: "Wedding",
      date: "2024-03-15",
      time: "15:00",
      venue: "Garden Manor",
      location: "Cape Town",
      status: "confirmed",
      image: "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=300",
      dressCode: "Formal",
      weather: "Sunny, 24°C",
      amenities: ["WiFi", "Parking", "Kids Area", "Wheelchair Access"]
    },
    {
      id: 2,
      coupleName: "Emma & David",
      eventType: "Engagement Party",
      date: "2024-02-28",
      time: "18:00",
      venue: "Sunset Terrace",
      location: "Johannesburg",
      status: "pending",
      image: "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=300",
      dressCode: "Smart Casual",
      weather: "Partly Cloudy, 22°C",
      amenities: ["WiFi", "Parking", "Bar"]
    },
    {
      id: 3,
      coupleName: "Lisa & James",
      eventType: "Bridal Shower",
      date: "2024-02-20",
      time: "14:00",
      venue: "Rose Garden",
      location: "Durban",
      status: "maybe",
      image: "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=300",
      dressCode: "Garden Party",
      weather: "Warm, 26°C",
      amenities: ["Parking", "Kids Area"]
    }
  ];

  const pendingRSVPs = [
    {
      id: 1,
      coupleName: "Sarah & Michael",
      eventType: "Wedding",
      date: "2024-03-15",
      deadline: "2024-02-15",
      guestCount: 2,
      mealOptions: ["Chicken", "Beef", "Vegetarian"],
      dietaryRestrictions: true,
      plusOneAllowed: true
    },
    {
      id: 2,
      coupleName: "Emma & David",
      eventType: "Engagement Party",
      date: "2024-02-28",
      deadline: "2024-02-20",
      guestCount: 1,
      mealOptions: ["Buffet Style"],
      dietaryRestrictions: false,
      plusOneAllowed: false
    }
  ];

  const giftRegistry = [
    {
      id: 1,
      coupleName: "Sarah & Michael",
      item: "Kitchen Stand Mixer",
      price: 2500,
      contributed: 1800,
      priority: "high",
      category: "Kitchen",
      image: "https://images.pexels.com/photos/4226796/pexels-photo-4226796.jpeg?auto=compress&cs=tinysrgb&w=300"
    },
    {
      id: 2,
      coupleName: "Sarah & Michael",
      item: "Honeymoon Fund",
      price: 15000,
      contributed: 8500,
      priority: "high",
      category: "Experience",
      image: "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=300"
    },
    {
      id: 3,
      coupleName: "Emma & David",
      item: "Dinner Set",
      price: 1200,
      contributed: 400,
      priority: "medium",
      category: "Dining",
      image: "https://images.pexels.com/photos/4226796/pexels-photo-4226796.jpeg?auto=compress&cs=tinysrgb&w=300"
    }
  ];

  const photos = [
    {
      id: 1,
      event: "Sarah & Michael's Wedding",
      image: "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=300",
      likes: 24,
      caption: "Beautiful ceremony!",
      tags: ["ceremony", "bride", "groom"]
    },
    {
      id: 2,
      event: "Emma & David's Engagement",
      image: "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=300",
      likes: 18,
      caption: "So happy for them!",
      tags: ["engagement", "couple", "celebration"]
    }
  ];

  const messages = [
    {
      id: 1,
      from: "Sarah & Michael",
      type: "thank-you",
      subject: "Thank you for your gift!",
      message: "We absolutely love the kitchen mixer! Thank you so much for your generous gift.",
      date: "2024-01-15",
      read: false
    },
    {
      id: 2,
      from: "Wedding Planner",
      type: "update",
      subject: "Venue Update",
      message: "The ceremony location has been moved to the garden due to weather.",
      date: "2024-01-10",
      read: true
    }
  ];

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'confirmed': return 'bg-green-100 text-green-800';
      case 'pending': return 'bg-yellow-100 text-yellow-800';
      case 'declined': return 'bg-red-100 text-red-800';
      case 'maybe': return 'bg-blue-100 text-blue-800';
      default: return 'bg-gray-100 text-gray-800';
    }
  };

  const getPriorityColor = (priority: string) => {
    switch (priority) {
      case 'high': return 'text-red-600';
      case 'medium': return 'text-yellow-600';
      case 'low': return 'text-green-600';
      default: return 'text-gray-600';
    }
  };

  const renderOverview = () => (
    <div className="space-y-6">
      {/* Header */}
      <div className="bg-gradient-to-r from-pink-500 to-rose-500 text-white p-6 rounded-lg">
        <h2 className="text-2xl font-bold mb-2">Welcome back, {userName}!</h2>
        <p className="opacity-90">Manage your wedding invitations and celebrations</p>
      </div>

      {/* Metrics */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div className="bg-white p-6 rounded-lg shadow-sm border">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-sm text-gray-600">Events Attending</p>
              <p className="text-2xl font-bold text-gray-900">3</p>
            </div>
            <Calendar className="w-8 h-8 text-pink-500" />
          </div>
        </div>
        <div className="bg-white p-6 rounded-lg shadow-sm border">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-sm text-gray-600">Pending RSVPs</p>
              <p className="text-2xl font-bold text-gray-900">2</p>
            </div>
            <AlertCircle className="w-8 h-8 text-yellow-500" />
          </div>
        </div>
        <div className="bg-white p-6 rounded-lg shadow-sm border">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-sm text-gray-600">Total Contributions</p>
              <p className="text-2xl font-bold text-gray-900">R10,700</p>
            </div>
            <Gift className="w-8 h-8 text-green-500" />
          </div>
        </div>
        <div className="bg-white p-6 rounded-lg shadow-sm border">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-sm text-gray-600">Photos Shared</p>
              <p className="text-2xl font-bold text-gray-900">12</p>
            </div>
            <Camera className="w-8 h-8 text-blue-500" />
          </div>
        </div>
      </div>

      {/* Quick Actions */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="bg-white p-6 rounded-lg shadow-sm border cursor-pointer hover:shadow-md transition-shadow"
             onClick={() => setActiveTab('rsvp')}>
          <div className="flex items-center space-x-3">
            <CheckCircle className="w-6 h-6 text-green-500" />
            <div>
              <h3 className="font-semibold">Complete RSVPs</h3>
              <p className="text-sm text-gray-600">2 pending responses</p>
            </div>
          </div>
        </div>
        <div className="bg-white p-6 rounded-lg shadow-sm border cursor-pointer hover:shadow-md transition-shadow"
             onClick={() => setActiveTab('gifts')}>
          <div className="flex items-center space-x-3">
            <Gift className="w-6 h-6 text-pink-500" />
            <div>
              <h3 className="font-semibold">Browse Gifts</h3>
              <p className="text-sm text-gray-600">Find perfect gifts</p>
            </div>
          </div>
        </div>
        <div className="bg-white p-6 rounded-lg shadow-sm border cursor-pointer hover:shadow-md transition-shadow"
             onClick={() => setActiveTab('photos')}>
          <div className="flex items-center space-x-3">
            <Camera className="w-6 h-6 text-blue-500" />
            <div>
              <h3 className="font-semibold">Share Photos</h3>
              <p className="text-sm text-gray-600">Upload memories</p>
            </div>
          </div>
        </div>
      </div>

      {/* Upcoming Events */}
      <div className="bg-white rounded-lg shadow-sm border">
        <div className="p-6 border-b">
          <h3 className="text-lg font-semibold">Upcoming Events</h3>
        </div>
        <div className="p-6 space-y-4">
          {upcomingEvents.slice(0, 3).map((event) => (
            <div key={event.id} className="flex items-center space-x-4 p-4 border rounded-lg">
              <img src={event.image} alt={event.coupleName} className="w-16 h-16 rounded-lg object-cover" />
              <div className="flex-1">
                <div className="flex items-center justify-between">
                  <h4 className="font-semibold">{event.coupleName} - {event.eventType}</h4>
                  <span className={`px-2 py-1 rounded-full text-xs font-medium ${getStatusColor(event.status)}`}>
                    {event.status}
                  </span>
                </div>
                <p className="text-sm text-gray-600">{event.date} at {event.time}</p>
                <p className="text-sm text-gray-500">{event.venue}, {event.location}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );

  const renderEvents = () => (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">My Events</h2>
        <div className="flex space-x-2">
          <div className="relative">
            <Search className="w-4 h-4 absolute left-3 top-3 text-gray-400" />
            <input
              type="text"
              placeholder="Search events..."
              className="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
          </div>
          <select
            className="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
            value={filterStatus}
            onChange={(e) => setFilterStatus(e.target.value)}
          >
            <option value="all">All Status</option>
            <option value="confirmed">Confirmed</option>
            <option value="pending">Pending</option>
            <option value="maybe">Maybe</option>
            <option value="declined">Declined</option>
          </select>
        </div>
      </div>

      {/* Events Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {upcomingEvents.map((event) => (
          <div key={event.id} className="bg-white rounded-lg shadow-sm border overflow-hidden">
            <img src={event.image} alt={event.coupleName} className="w-full h-48 object-cover" />
            <div className="p-6">
              <div className="flex items-center justify-between mb-2">
                <h3 className="font-semibold text-lg">{event.coupleName}</h3>
                <span className={`px-2 py-1 rounded-full text-xs font-medium ${getStatusColor(event.status)}`}>
                  {event.status}
                </span>
              </div>
              <p className="text-pink-600 font-medium mb-2">{event.eventType}</p>
              <div className="space-y-2 text-sm text-gray-600">
                <div className="flex items-center space-x-2">
                  <Calendar className="w-4 h-4" />
                  <span>{event.date} at {event.time}</span>
                </div>
                <div className="flex items-center space-x-2">
                  <MapPin className="w-4 h-4" />
                  <span>{event.venue}, {event.location}</span>
                </div>
                <div className="flex items-center space-x-2">
                  <Sun className="w-4 h-4" />
                  <span>{event.weather}</span>
                </div>
              </div>
              <div className="mt-4 pt-4 border-t">
                <p className="text-sm text-gray-600 mb-2">Dress Code: <span className="font-medium">{event.dressCode}</span></p>
                <div className="flex flex-wrap gap-1">
                  {event.amenities.map((amenity, index) => (
                    <span key={index} className="px-2 py-1 bg-gray-100 text-xs rounded">
                      {amenity}
                    </span>
                  ))}
                </div>
              </div>
              <div className="mt-4 flex space-x-2">
                <button 
                  className="flex-1 bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600 transition-colors"
                  onClick={() => setSelectedEvent(event)}
                >
                  View Details
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Event Details Modal */}
      {selectedEvent && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div className="p-6 border-b">
              <div className="flex justify-between items-center">
                <h3 className="text-xl font-bold">{selectedEvent.coupleName} - {selectedEvent.eventType}</h3>
                <button onClick={() => setSelectedEvent(null)} className="text-gray-500 hover:text-gray-700">
                  <XCircle className="w-6 h-6" />
                </button>
              </div>
            </div>
            <div className="p-6 space-y-6">
              <img src={selectedEvent.image} alt={selectedEvent.coupleName} className="w-full h-64 object-cover rounded-lg" />
              
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <h4 className="font-semibold mb-3">Event Details</h4>
                  <div className="space-y-2 text-sm">
                    <div className="flex items-center space-x-2">
                      <Calendar className="w-4 h-4 text-gray-500" />
                      <span>{selectedEvent.date} at {selectedEvent.time}</span>
                    </div>
                    <div className="flex items-center space-x-2">
                      <MapPin className="w-4 h-4 text-gray-500" />
                      <span>{selectedEvent.venue}, {selectedEvent.location}</span>
                    </div>
                    <div className="flex items-center space-x-2">
                      <Sun className="w-4 h-4 text-gray-500" />
                      <span>{selectedEvent.weather}</span>
                    </div>
                  </div>
                </div>
                
                <div>
                  <h4 className="font-semibold mb-3">Amenities</h4>
                  <div className="grid grid-cols-2 gap-2">
                    {selectedEvent.amenities.map((amenity, index) => (
                      <div key={index} className="flex items-center space-x-2 text-sm">
                        {amenity === 'WiFi' && <Wifi className="w-4 h-4 text-green-500" />}
                        {amenity === 'Parking' && <Car className="w-4 h-4 text-blue-500" />}
                        {amenity === 'Kids Area' && <Baby className="w-4 h-4 text-purple-500" />}
                        {amenity === 'Wheelchair Access' && <Users className="w-4 h-4 text-orange-500" />}
                        {amenity === 'Bar' && <Utensils className="w-4 h-4 text-red-500" />}
                        <span>{amenity}</span>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
              
              <div className="bg-gray-50 p-4 rounded-lg">
                <h4 className="font-semibold mb-2">Dress Code</h4>
                <p className="text-sm text-gray-600">{selectedEvent.dressCode}</p>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );

  const renderRSVP = () => (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">RSVP Center</h2>
        <div className="bg-white p-4 rounded-lg shadow-sm border">
          <div className="flex items-center space-x-4 text-sm">
            <div className="flex items-center space-x-2">
              <div className="w-3 h-3 bg-green-500 rounded-full"></div>
              <span>Confirmed: 1</span>
            </div>
            <div className="flex items-center space-x-2">
              <div className="w-3 h-3 bg-yellow-500 rounded-full"></div>
              <span>Pending: 2</span>
            </div>
            <div className="flex items-center space-x-2">
              <div className="w-3 h-3 bg-red-500 rounded-full"></div>
              <span>Declined: 0</span>
            </div>
          </div>
        </div>
      </div>

      {/* Pending RSVPs */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {pendingRSVPs.map((rsvp) => (
          <div key={rsvp.id} className="bg-white rounded-lg shadow-sm border">
            <div className="p-6">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-lg font-semibold">{rsvp.coupleName}</h3>
                <span className="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                  Pending
                </span>
              </div>
              
              <div className="space-y-3 text-sm text-gray-600 mb-6">
                <div className="flex items-center space-x-2">
                  <Calendar className="w-4 h-4" />
                  <span>{rsvp.eventType} on {rsvp.date}</span>
                </div>
                <div className="flex items-center space-x-2">
                  <Clock className="w-4 h-4" />
                  <span>RSVP by {rsvp.deadline}</span>
                </div>
                <div className="flex items-center space-x-2">
                  <Users className="w-4 h-4" />
                  <span>Guest count: {rsvp.guestCount}</span>
                </div>
              </div>

              <div className="space-y-4">
                {rsvp.plusOneAllowed && (
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Will you bring a plus one?
                    </label>
                    <div className="flex space-x-4">
                      <label className="flex items-center">
                        <input type="radio" name={`plusone-${rsvp.id}`} className="mr-2" />
                        <span className="text-sm">Yes</span>
                      </label>
                      <label className="flex items-center">
                        <input type="radio" name={`plusone-${rsvp.id}`} className="mr-2" />
                        <span className="text-sm">No</span>
                      </label>
                    </div>
                  </div>
                )}

                {rsvp.mealOptions.length > 0 && (
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Meal Preference
                    </label>
                    <select className="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                      <option value="">Select meal preference</option>
                      {rsvp.mealOptions.map((option, index) => (
                        <option key={index} value={option}>{option}</option>
                      ))}
                    </select>
                  </div>
                )}

                {rsvp.dietaryRestrictions && (
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Dietary Restrictions
                    </label>
                    <textarea 
                      className="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                      rows={2}
                      placeholder="Please specify any dietary restrictions..."
                    />
                  </div>
                )}

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Special Message (Optional)
                  </label>
                  <textarea 
                    className="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                    rows={3}
                    placeholder="Send a message to the couple..."
                  />
                </div>
              </div>

              <div className="mt-6 flex space-x-3">
                <button className="flex-1 bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition-colors">
                  Accept
                </button>
                <button className="flex-1 bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600 transition-colors">
                  Maybe
                </button>
                <button className="flex-1 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors">
                  Decline
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );

  const renderGifts = () => (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">Gift Registry</h2>
        <div className="bg-white p-4 rounded-lg shadow-sm border">
          <p className="text-sm text-gray-600">Total Contributed: <span className="font-bold text-green-600">R10,700</span></p>
        </div>
      </div>

      {/* Gift Registry Items */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {giftRegistry.map((gift) => (
          <div key={gift.id} className="bg-white rounded-lg shadow-sm border overflow-hidden">
            <img src={gift.image} alt={gift.item} className="w-full h-48 object-cover" />
            <div className="p-6">
              <div className="flex items-center justify-between mb-2">
                <h3 className="font-semibold text-lg">{gift.item}</h3>
                <Star className={`w-5 h-5 ${getPriorityColor(gift.priority)}`} />
              </div>
              
              <p className="text-gray-600 mb-2">For {gift.coupleName}</p>
              <p className="text-sm text-gray-500 mb-4">{gift.category}</p>
              
              <div className="mb-4">
                <div className="flex justify-between text-sm mb-1">
                  <span>Progress</span>
                  <span>R{gift.contributed} / R{gift.price}</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div 
                    className="bg-pink-500 h-2 rounded-full" 
                    style={{ width: `${(gift.contributed / gift.price) * 100}%` }}
                  ></div>
                </div>
                <p className="text-xs text-gray-500 mt-1">
                  {Math.round((gift.contributed / gift.price) * 100)}% funded
                </p>
              </div>

              <div className="flex space-x-2">
                <button 
                  className="flex-1 bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600 transition-colors"
                  onClick={() => setSelectedGift(gift)}
                >
                  Contribute
                </button>
                <button className="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                  <Heart className="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Gift Contribution Modal */}
      {selectedGift && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-lg max-w-md w-full">
            <div className="p-6 border-b">
              <div className="flex justify-between items-center">
                <h3 className="text-xl font-bold">Contribute to Gift</h3>
                <button onClick={() => setSelectedGift(null)} className="text-gray-500 hover:text-gray-700">
                  <XCircle className="w-6 h-6" />
                </button>
              </div>
            </div>
            <div className="p-6 space-y-4">
              <div className="text-center">
                <img src={selectedGift.image} alt={selectedGift.item} className="w-32 h-32 object-cover rounded-lg mx-auto mb-4" />
                <h4 className="font-semibold text-lg">{selectedGift.item}</h4>
                <p className="text-gray-600">For {selectedGift.coupleName}</p>
              </div>
              
              <div className="bg-gray-50 p-4 rounded-lg">
                <div className="flex justify-between text-sm mb-2">
                  <span>Current Progress</span>
                  <span>R{selectedGift.contributed} / R{selectedGift.price}</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2 mb-2">
                  <div 
                    className="bg-pink-500 h-2 rounded-full" 
                    style={{ width: `${(selectedGift.contributed / selectedGift.price) * 100}%` }}
                  ></div>
                </div>
                <p className="text-xs text-gray-500">
                  Remaining: R{selectedGift.price - selectedGift.contributed}
                </p>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Contribution Amount
                </label>
                <input 
                  type="number" 
                  className="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                  placeholder="Enter amount"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Personal Message (Optional)
                </label>
                <textarea 
                  className="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                  rows={3}
                  placeholder="Add a personal message..."
                />
              </div>

              <div className="flex space-x-3">
                <button 
                  className="flex-1 bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600 transition-colors"
                  onClick={() => setSelectedGift(null)}
                >
                  Contribute Now
                </button>
                <button 
                  className="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                  onClick={() => setSelectedGift(null)}
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );

  const renderPhotos = () => (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">Photo Gallery</h2>
        <button className="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-colors flex items-center space-x-2">
          <Upload className="w-4 h-4" />
          <span>Upload Photos</span>
        </button>
      </div>

      {/* Photo Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {photos.map((photo) => (
          <div key={photo.id} className="bg-white rounded-lg shadow-sm border overflow-hidden">
            <img src={photo.image} alt={photo.caption} className="w-full h-64 object-cover" />
            <div className="p-4">
              <h3 className="font-semibold mb-2">{photo.event}</h3>
              <p className="text-gray-600 text-sm mb-3">{photo.caption}</p>
              
              <div className="flex flex-wrap gap-1 mb-3">
                {photo.tags.map((tag, index) => (
                  <span key={index} className="px-2 py-1 bg-gray-100 text-xs rounded">
                    #{tag}
                  </span>
                ))}
              </div>
              
              <div className="flex items-center justify-between">
                <div className="flex items-center space-x-2">
                  <button className="flex items-center space-x-1 text-gray-600 hover:text-pink-500">
                    <ThumbsUp className="w-4 h-4" />
                    <span className="text-sm">{photo.likes}</span>
                  </button>
                  <button className="text-gray-600 hover:text-pink-500">
                    <Share2 className="w-4 h-4" />
                  </button>
                </div>
                <button className="text-gray-600 hover:text-pink-500">
                  <Bookmark className="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );

  const renderMessages = () => (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">Messages</h2>
        <div className="flex space-x-2">
          <button className="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            Mark All Read
          </button>
        </div>
      </div>

      {/* Messages List */}
      <div className="space-y-4">
        {messages.map((message) => (
          <div key={message.id} className={`bg-white rounded-lg shadow-sm border p-6 ${!message.read ? 'border-l-4 border-l-pink-500' : ''}`}>
            <div className="flex items-center justify-between mb-3">
              <div className="flex items-center space-x-3">
                <div className={`w-3 h-3 rounded-full ${message.type === 'thank-you' ? 'bg-green-500' : message.type === 'update' ? 'bg-blue-500' : 'bg-gray-500'}`}></div>
                <h3 className="font-semibold">{message.subject}</h3>
                {!message.read && <span className="px-2 py-1 bg-pink-100 text-pink-800 text-xs rounded-full">New</span>}
              </div>
              <span className="text-sm text-gray-500">{message.date}</span>
            </div>
            
            <p className="text-gray-600 mb-3">{message.message}</p>
            
            <div className="flex items-center justify-between">
              <span className="text-sm text-gray-500">From: {message.from}</span>
              <div className="flex space-x-2">
                <button className="px-3 py-1 bg-pink-500 text-white text-sm rounded hover:bg-pink-600 transition-colors">
                  Reply
                </button>
                <button className="px-3 py-1 border border-gray-300 text-sm rounded hover:bg-gray-50 transition-colors">
                  Archive
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );

  const renderTravel = () => (
    <div className="space-y-6">
      {/* Header */}
      <h2 className="text-2xl font-bold">Travel & Accommodation</h2>

      {/* Travel Information */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {upcomingEvents.map((event) => (
          <div key={event.id} className="bg-white rounded-lg shadow-sm border">
            <div className="p-6">
              <h3 className="text-lg font-semibold mb-4">{event.coupleName} - {event.eventType}</h3>
              
              <div className="space-y-4">
                <div>
                  <h4 className="font-medium mb-2 flex items-center">
                    <MapPin className="w-4 h-4 mr-2 text-gray-500" />
                    Venue Information
                  </h4>
                  <p className="text-sm text-gray-600">{event.venue}</p>
                  <p className="text-sm text-gray-600">{event.location}</p>
                </div>

                <div>
                  <h4 className="font-medium mb-2 flex items-center">
                    <Car className="w-4 h-4 mr-2 text-gray-500" />
                    Transportation
                  </h4>
                  <p className="text-sm text-gray-600">Free parking available</p>
                  <p className="text-sm text-gray-600">Shuttle service from main hotels</p>
                </div>

                <div>
                  <h4 className="font-medium mb-2 flex items-center">
                    <Bed className="w-4 h-4 mr-2 text-gray-500" />
                    Accommodation
                  </h4>
                  <p className="text-sm text-gray-600">Recommended hotels nearby</p>
                  <p className="text-sm text-gray-600">Group discount available</p>
                </div>

                <div>
                  <h4 className="font-medium mb-2 flex items-center">
                    <Sun className="w-4 h-4 mr-2 text-gray-500" />
                    Weather
                  </h4>
                  <p className="text-sm text-gray-600">{event.weather}</p>
                  <p className="text-sm text-gray-600">Dress accordingly</p>
                </div>
              </div>

              <div className="mt-6 pt-4 border-t">
                <h4 className="font-medium mb-2">Contact Information</h4>
                <div className="flex space-x-4">
                  <button className="flex items-center space-x-2 text-sm text-gray-600 hover:text-pink-500">
                    <Phone className="w-4 h-4" />
                    <span>Call Venue</span>
                  </button>
                  <button className="flex items-center space-x-2 text-sm text-gray-600 hover:text-pink-500">
                    <Mail className="w-4 h-4" />
                    <span>Email Couple</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );

  const renderMemories = () => (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">Wedding Memories</h2>
        <button className="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-colors flex items-center space-x-2">
          <Plus className="w-4 h-4" />
          <span>Add Memory</span>
        </button>
      </div>

      {/* Memory Collection */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div className="bg-white rounded-lg shadow-sm border overflow-hidden">
          <img src="https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Wedding Memory" className="w-full h-48 object-cover" />
          <div className="p-6">
            <h3 className="font-semibold text-lg mb-2">Sarah & Michael's Wedding</h3>
            <p className="text-gray-600 text-sm mb-4">March 15, 2024 - Garden Manor, Cape Town</p>
            <p className="text-gray-700 mb-4">Such a beautiful ceremony! The garden setting was perfect and the couple looked absolutely radiant. The speeches were so heartfelt.</p>
            
            <div className="flex items-center justify-between">
              <div className="flex items-center space-x-2">
                <Heart className="w-4 h-4 text-red-500" />
                <span className="text-sm text-gray-600">Loved this wedding</span>
              </div>
              <button className="text-pink-500 hover:text-pink-600">
                <Bookmark className="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>

        <div className="bg-white rounded-lg shadow-sm border overflow-hidden">
          <img src="https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Wedding Memory" className="w-full h-48 object-cover" />
          <div className="p-6">
            <h3 className="font-semibold text-lg mb-2">Emma & David's Engagement</h3>
            <p className="text-gray-600 text-sm mb-4">February 28, 2024 - Sunset Terrace, Johannesburg</p>
            <p className="text-gray-700 mb-4">Amazing engagement party with stunning sunset views. The surprise proposal story was so romantic!</p>
            
            <div className="flex items-center justify-between">
              <div className="flex items-center space-x-2">
                <Heart className="w-4 h-4 text-red-500" />
                <span className="text-sm text-gray-600">Loved this celebration</span>
              </div>
              <button className="text-pink-500 hover:text-pink-600">
                <Bookmark className="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* Personal Notes */}
      <div className="bg-white rounded-lg shadow-sm border">
        <div className="p-6 border-b">
          <h3 className="text-lg font-semibold">Personal Notes</h3>
        </div>
        <div className="p-6">
          <textarea 
            className="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
            rows={4}
            placeholder="Add your personal thoughts and memories from the weddings you've attended..."
          />
          <button className="mt-3 bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-colors">
            Save Note
          </button>
        </div>
      </div>
    </div>
  );

  const tabs = [
    { id: 'overview', label: 'Overview', icon: Calendar },
    { id: 'events', label: 'My Events', icon: Calendar },
    { id: 'rsvp', label: 'RSVP Center', icon: CheckCircle },
    { id: 'gifts', label: 'Gift Registry', icon: Gift },
    { id: 'photos', label: 'Photos', icon: Camera },
    { id: 'messages', label: 'Messages', icon: MessageCircle },
    { id: 'travel', label: 'Travel', icon: MapPin },
    { id: 'memories', label: 'Memories', icon: Heart }
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Navigation */}
      <div className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex space-x-8 overflow-x-auto">
            {tabs.map((tab) => {
              const Icon = tab.icon;
              return (
                <button
                  key={tab.id}
                  onClick={() => setActiveTab(tab.id)}
                  className={`flex items-center space-x-2 py-4 px-2 border-b-2 font-medium text-sm whitespace-nowrap ${
                    activeTab === tab.id
                      ? 'border-pink-500 text-pink-600'
                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                  }`}
                >
                  <Icon className="w-4 h-4" />
                  <span>{tab.label}</span>
                </button>
              );
            })}
          </div>
        </div>
      </div>

      {/* Content */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {activeTab === 'overview' && renderOverview()}
        {activeTab === 'events' && renderEvents()}
        {activeTab === 'rsvp' && renderRSVP()}
        {activeTab === 'gifts' && renderGifts()}
        {activeTab === 'photos' && renderPhotos()}
        {activeTab === 'messages' && renderMessages()}
        {activeTab === 'travel' && renderTravel()}
        {activeTab === 'memories' && renderMemories()}
      </div>
    </div>
  );
};

export default GuestDashboard;
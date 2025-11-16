import React, { useState } from 'react';
import { MapPin, Calendar, DollarSign, Users, TrendingUp, Award, Star, Crown } from 'lucide-react';

interface VenueDashboardProps {
  userName: string;
}

const VenueDashboard: React.FC<VenueDashboardProps> = ({ userName }) => {
  const [selectedTab, setSelectedTab] = useState('overview');

  const tabs = [
    { id: 'overview', label: 'Overview', icon: TrendingUp },
    { id: 'bookings', label: 'Bookings', icon: Calendar },
    { id: 'availability', label: 'Availability', icon: MapPin },
    { id: 'analytics', label: 'Analytics', icon: DollarSign }
  ];

  const stats = [
    { label: 'Total Bookings', value: '18', icon: Calendar, color: 'blue' },
    { label: 'Monthly Revenue', value: 'R68,400', icon: DollarSign, color: 'green' },
    { label: 'Inquiries', value: '24', icon: Users, color: 'purple' },
    { label: 'Average Rating', value: '4.9', icon: Star, color: 'yellow' }
  ];

  const upcomingEvents = [
    { id: 1, couple: 'John & Sarah', date: '2025-06-15', guests: 120, amount: 'R35,000' },
    { id: 2, couple: 'Mike & Lisa', date: '2025-07-22', guests: 90, amount: 'R28,000' },
    { id: 3, couple: 'David & Emma', date: '2025-08-10', guests: 150, amount: 'R42,000' }
  ];

  return (
    <div className="p-6">
      {/* Header */}
      <div className="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-6 text-white mb-8">
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold mb-2">Welcome back, {userName}! 🏛️</h1>
            <p className="text-green-100">Riverside Garden Estate Management</p>
          </div>
          <div className="flex items-center space-x-2">
            <Crown className="h-6 w-6 text-yellow-400" />
            <span className="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">Premium Venue</span>
          </div>
        </div>
      </div>

      {/* Navigation Tabs */}
      <div className="mb-8">
        <div className="flex space-x-1 bg-white rounded-xl p-1 shadow-sm">
          {tabs.map((tab) => {
            const Icon = tab.icon;
            return (
              <button
                key={tab.id}
                onClick={() => setSelectedTab(tab.id)}
                className={`flex items-center space-x-2 px-6 py-3 rounded-lg font-medium transition-all duration-200 flex-1 justify-center ${
                  selectedTab === tab.id
                    ? 'bg-green-500 text-white shadow-md'
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
              return (
                <div key={stat.label} className="bg-white rounded-xl p-6 shadow-sm">
                  <div className="flex items-center space-x-3">
                    <div className={`w-10 h-10 bg-${stat.color}-100 rounded-lg flex items-center justify-center`}>
                      <Icon className={`h-5 w-5 text-${stat.color}-600`} />
                    </div>
                    <div>
                      <div className="text-2xl font-bold text-gray-900">{stat.value}</div>
                      <div className="text-sm text-gray-600">{stat.label}</div>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>

          {/* Upcoming Events */}
          <div className="bg-white rounded-xl p-6 shadow-sm">
            <h3 className="text-lg font-semibold text-gray-900 mb-4">Upcoming Events</h3>
            <div className="space-y-3">
              {upcomingEvents.map((event) => (
                <div key={event.id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                  <div>
                    <div className="font-medium text-gray-900">{event.couple}</div>
                    <div className="text-sm text-gray-500">{event.date} • {event.guests} guests</div>
                  </div>
                  <div className="text-right">
                    <div className="font-medium text-gray-900">{event.amount}</div>
                    <div className="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Confirmed</div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'availability' && (
        <div className="bg-white rounded-xl p-6 shadow-sm">
          <h3 className="text-lg font-semibold text-gray-900 mb-6">Availability Calendar</h3>
          <div className="grid grid-cols-7 gap-2 mb-4">
            {['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].map((day) => (
              <div key={day} className="text-center text-sm font-medium text-gray-600 p-2">
                {day}
              </div>
            ))}
          </div>
          <div className="text-center py-12 text-gray-500">
            <Calendar className="h-12 w-12 mx-auto mb-4" />
            <p>Calendar integration coming soon</p>
          </div>
        </div>
      )}
    </div>
  );
};

export default VenueDashboard;
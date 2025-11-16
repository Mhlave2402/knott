import React, { useState } from 'react';
import { Briefcase, TrendingUp, DollarSign, Users, Calendar, Star, Crown, Camera } from 'lucide-react';

interface ProDashboardProps {
  userName: string;
}

const ProDashboard: React.FC<ProDashboardProps> = ({ userName }) => {
  const [selectedTab, setSelectedTab] = useState('overview');

  const tabs = [
    { id: 'overview', label: 'Overview', icon: TrendingUp },
    { id: 'bookings', label: 'Bookings', icon: Calendar },
    { id: 'portfolio', label: 'Portfolio', icon: Camera },
    { id: 'analytics', label: 'Analytics', icon: DollarSign }
  ];

  const stats = [
    { label: 'Total Bookings', value: '23', icon: Calendar, color: 'blue' },
    { label: 'Monthly Revenue', value: 'R45,600', icon: DollarSign, color: 'green' },
    { label: 'Profile Views', value: '1,247', icon: Users, color: 'purple' },
    { label: 'Average Rating', value: '4.8', icon: Star, color: 'yellow' }
  ];

  const recentBookings = [
    { id: 1, couple: 'John & Sarah', date: '2025-06-15', amount: 'R22,000', status: 'Confirmed' },
    { id: 2, couple: 'Mike & Lisa', date: '2025-07-22', amount: 'R18,500', status: 'Pending' },
    { id: 3, couple: 'David & Emma', date: '2025-08-10', amount: 'R25,000', status: 'Confirmed' }
  ];

  return (
    <div className="p-6">
      {/* Header */}
      <div className="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl p-6 text-white mb-8">
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold mb-2">Welcome back, {userName}! 📸</h1>
            <p className="text-blue-100">Manage your wedding photography business</p>
          </div>
          <div className="flex items-center space-x-2">
            <Crown className="h-6 w-6 text-yellow-400" />
            <span className="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">Premium Member</span>
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
                    ? 'bg-blue-500 text-white shadow-md'
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

          {/* Recent Activity */}
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">Recent Bookings</h3>
              <div className="space-y-3">
                {recentBookings.map((booking) => (
                  <div key={booking.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                      <div className="font-medium text-gray-900">{booking.couple}</div>
                      <div className="text-sm text-gray-500">{booking.date}</div>
                    </div>
                    <div className="text-right">
                      <div className="font-medium text-gray-900">{booking.amount}</div>
                      <div className={`text-xs px-2 py-1 rounded-full ${
                        booking.status === 'Confirmed' 
                          ? 'bg-green-100 text-green-700' 
                          : 'bg-yellow-100 text-yellow-700'
                      }`}>
                        {booking.status}
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">AI Insights</h3>
              <div className="space-y-4">
                <div className="p-4 bg-blue-50 rounded-lg">
                  <div className="font-medium text-blue-900 mb-1">Pricing Optimization</div>
                  <div className="text-sm text-blue-700">Consider increasing portrait session rates by 15%</div>
                </div>
                <div className="p-4 bg-green-50 rounded-lg">
                  <div className="font-medium text-green-900 mb-1">Peak Season Alert</div>
                  <div className="text-sm text-green-700">High demand period approaching - update availability</div>
                </div>
                <div className="p-4 bg-purple-50 rounded-lg">
                  <div className="font-medium text-purple-900 mb-1">New Lead Opportunity</div>
                  <div className="text-sm text-purple-700">3 couples matching your style preferences</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default ProDashboard;
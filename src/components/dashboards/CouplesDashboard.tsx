import React, { useState } from 'react';
import { Calendar, DollarSign, Users, CheckCircle, Heart, Sparkles, Clock, MapPin, Camera, Music, Utensils, Gift, Star, Crown, Award, TrendingUp, AlertCircle, Plus, CreditCard as Edit, Download, Share, Bell, MessageCircle, Phone, Mail, Filter, Search, X, ChevronRight, Target, PieChart, BarChart3, Calendar as CalendarIcon, FileText, Settings } from 'lucide-react';

interface CouplesDashboardProps {
  userName: string;
}

interface Task {
  id: number;
  title: string;
  completed: boolean;
  dueDate: string;
  category: string;
  priority: 'high' | 'medium' | 'low';
  assignedTo?: string;
  notes?: string;
}

interface Vendor {
  id: string;
  name: string;
  category: string;
  status: 'booked' | 'contacted' | 'quoted' | 'declined';
  rating: number;
  price: number;
  paid: number;
  contact: string;
  image: string;
  nextPayment?: string;
}

interface Guest {
  id: string;
  name: string;
  email: string;
  phone: string;
  rsvpStatus: 'pending' | 'attending' | 'declined' | 'maybe';
  dietaryRestrictions?: string;
  plusOne: boolean;
  group: string;
}

const CouplesDashboard: React.FC<CouplesDashboardProps> = ({ userName }) => {
  const [selectedTab, setSelectedTab] = useState('overview');
  const [showTaskModal, setShowTaskModal] = useState(false);
  const [showVendorModal, setShowVendorModal] = useState(false);
  const [selectedVendor, setSelectedVendor] = useState<Vendor | null>(null);

  const weddingDate = new Date('2025-06-15');
  const daysUntilWedding = Math.ceil(
    (weddingDate.getTime() - new Date().getTime()) / (1000 * 60 * 60 * 24)
  );

  const tabs = [
    { id: 'overview', label: 'Overview', icon: Heart },
    { id: 'budget', label: 'Budget', icon: DollarSign },
    { id: 'vendors', label: 'Vendors', icon: Users },
    { id: 'timeline', label: 'Timeline', icon: Calendar },
    { id: 'guests', label: 'Guests', icon: Users },
    { id: 'inspiration', label: 'Inspiration', icon: Sparkles },
    { id: 'documents', label: 'Documents', icon: FileText },
    { id: 'settings', label: 'Settings', icon: Settings },
  ];

  const tasks: Task[] = [
    { id: 1, title: 'Book venue', completed: true, dueDate: '2024-12-01', category: 'Venue', priority: 'high' },
    { id: 2, title: 'Send invitations', completed: true, dueDate: '2025-03-15', category: 'Invitations', priority: 'high' },
    { id: 3, title: 'Final dress fitting', completed: false, dueDate: '2025-05-20', category: 'Attire', priority: 'medium' },
    { id: 4, title: 'Choose wedding cake', completed: false, dueDate: '2025-04-10', category: 'Catering', priority: 'medium' },
    { id: 5, title: 'Book transportation', completed: false, dueDate: '2025-05-01', category: 'Transportation', priority: 'low' },
    { id: 6, title: 'Confirm menu with caterer', completed: false, dueDate: '2025-04-15', category: 'Catering', priority: 'high' },
  ];

  const vendors: Vendor[] = [
    {
      id: '1',
      name: 'Elegant Memories Photography',
      category: 'Photography',
      status: 'booked',
      rating: 4.9,
      price: 22000,
      paid: 5500,
      contact: 'info@elegantmemories.co.za',
      image: 'https://images.pexels.com/photos/1024996/pexels-photo-1024996.jpeg?auto=compress&cs=tinysrgb&w=100',
      nextPayment: '2025-04-01'
    },
    {
      id: '2',
      name: 'Riverside Garden Estate',
      category: 'Venue',
      status: 'booked',
      rating: 4.8,
      price: 38000,
      paid: 38000,
      contact: 'bookings@riverside.co.za',
      image: 'https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=100'
    },
    {
      id: '3',
      name: 'Blooming Gardens Florist',
      category: 'Florals',
      status: 'quoted',
      rating: 4.7,
      price: 12000,
      paid: 0,
      contact: 'hello@bloominggardens.co.za',
      image: 'https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=100'
    }
  ];

  const budgetCategories = [
    { name: 'Venue', budgeted: 40000, spent: 38000, color: 'blue' },
    { name: 'Photography', budgeted: 22000, spent: 5500, color: 'purple' },
    { name: 'Catering', budgeted: 35000, spent: 5000, color: 'green' },
    { name: 'Florals', budgeted: 12000, spent: 0, color: 'pink' },
    { name: 'Entertainment', budgeted: 15000, spent: 0, color: 'yellow' },
    { name: 'Attire', budgeted: 8000, spent: 3500, color: 'indigo' },
    { name: 'Transportation', budgeted: 5000, spent: 0, color: 'red' },
    { name: 'Miscellaneous', budgeted: 8000, spent: 1200, color: 'gray' },
  ];

  const guests: Guest[] = [
    { id: '1', name: 'John Smith', email: 'john@email.com', phone: '+27 82 123 4567', rsvpStatus: 'attending', plusOne: true, group: 'Family' },
    { id: '2', name: 'Sarah Johnson', email: 'sarah@email.com', phone: '+27 83 234 5678', rsvpStatus: 'pending', plusOne: false, group: 'Friends' },
    { id: '3', name: 'Mike Wilson', email: 'mike@email.com', phone: '+27 84 345 6789', rsvpStatus: 'attending', plusOne: true, group: 'Work' },
  ];

  const colorMap: Record<string, string> = {
    blue: 'bg-blue-500',
    purple: 'bg-purple-500',
    green: 'bg-green-500',
    pink: 'bg-pink-500',
    yellow: 'bg-yellow-500',
    indigo: 'bg-indigo-500',
    red: 'bg-red-500',
    gray: 'bg-gray-500',
  };

  const totalBudget = budgetCategories.reduce((sum, cat) => sum + cat.budgeted, 0);
  const totalSpent = budgetCategories.reduce((sum, cat) => sum + cat.spent, 0);
  const completedTasks = tasks.filter(t => t.completed).length;
  const attendingGuests = guests.filter(g => g.rsvpStatus === 'attending').length;
  const totalGuests = guests.length;

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'booked': return 'bg-green-100 text-green-700';
      case 'contacted': return 'bg-blue-100 text-blue-700';
      case 'quoted': return 'bg-yellow-100 text-yellow-700';
      case 'declined': return 'bg-red-100 text-red-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  const getPriorityColor = (priority: string) => {
    switch (priority) {
      case 'high': return 'bg-red-100 text-red-700';
      case 'medium': return 'bg-yellow-100 text-yellow-700';
      case 'low': return 'bg-green-100 text-green-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  const getRsvpColor = (status: string) => {
    switch (status) {
      case 'attending': return 'bg-green-100 text-green-700';
      case 'declined': return 'bg-red-100 text-red-700';
      case 'maybe': return 'bg-yellow-100 text-yellow-700';
      case 'pending': return 'bg-gray-100 text-gray-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  return (
    <div className="p-6">
      {/* Header */}
      <div className="bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl p-6 text-white mb-8">
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold mb-2">Welcome back, {userName}! 💕</h1>
            <p className="text-pink-100">Your dream wedding is getting closer</p>
            <div className="flex items-center space-x-4 mt-3">
              <div className="flex items-center space-x-2">
                <Calendar className="h-4 w-4" />
                <span className="text-sm">June 15, 2025</span>
              </div>
              <div className="flex items-center space-x-2">
                <MapPin className="h-4 w-4" />
                <span className="text-sm">Riverside Garden Estate</span>
              </div>
            </div>
          </div>
          <div className="text-right">
            <div className="text-4xl font-bold">{daysUntilWedding}</div>
            <div className="text-sm text-pink-100">days to go</div>
            <div className="mt-2">
              <div className="text-xs text-pink-200">Wedding Progress</div>
              <div className="w-32 bg-pink-400 rounded-full h-2 mt-1">
                <div 
                  className="bg-white h-2 rounded-full transition-all duration-500"
                  style={{ width: `${(completedTasks / tasks.length) * 100}%` }}
                ></div>
              </div>
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
                    ? 'bg-pink-500 text-white shadow-md'
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
          {/* Quick Stats */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3 mb-4">
                <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                  <DollarSign className="h-5 w-5 text-blue-600" />
                </div>
                <div>
                  <h3 className="font-semibold text-gray-900">Budget Status</h3>
                  <p className="text-sm text-gray-600">
                    {((totalSpent / totalBudget) * 100).toFixed(1)}% used
                  </p>
                </div>
              </div>
              <div className="text-2xl font-bold text-gray-900">
                R{totalSpent.toLocaleString()} / R{totalBudget.toLocaleString()}
              </div>
              <div className="w-full bg-gray-200 rounded-full h-2 mt-3">
                <div 
                  className="bg-blue-500 h-2 rounded-full transition-all duration-500"
                  style={{ width: `${(totalSpent / totalBudget) * 100}%` }}
                ></div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3 mb-4">
                <div className="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                  <CheckCircle className="h-5 w-5 text-green-600" />
                </div>
                <div>
                  <h3 className="font-semibold text-gray-900">Tasks Complete</h3>
                  <p className="text-sm text-gray-600">Keep up the great work!</p>
                </div>
              </div>
              <div className="text-2xl font-bold text-gray-900">
                {completedTasks} / {tasks.length}
              </div>
              <div className="w-full bg-gray-200 rounded-full h-2 mt-3">
                <div 
                  className="bg-green-500 h-2 rounded-full transition-all duration-500"
                  style={{ width: `${(completedTasks / tasks.length) * 100}%` }}
                ></div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3 mb-4">
                <div className="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                  <Users className="h-5 w-5 text-purple-600" />
                </div>
                <div>
                  <h3 className="font-semibold text-gray-900">Guest RSVPs</h3>
                  <p className="text-sm text-gray-600">Confirmed attendees</p>
                </div>
              </div>
              <div className="text-2xl font-bold text-gray-900">{attendingGuests} / {totalGuests}</div>
              <div className="w-full bg-gray-200 rounded-full h-2 mt-3">
                <div 
                  className="bg-purple-500 h-2 rounded-full transition-all duration-500"
                  style={{ width: `${(attendingGuests / totalGuests) * 100}%` }}
                ></div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3 mb-4">
                <div className="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                  <Sparkles className="h-5 w-5 text-pink-600" />
                </div>
                <div>
                  <h3 className="font-semibold text-gray-900">Vendors Booked</h3>
                  <p className="text-sm text-gray-600">Confirmed services</p>
                </div>
              </div>
              <div className="text-2xl font-bold text-gray-900">
                {vendors.filter(v => v.status === 'booked').length} / {vendors.length}
              </div>
              <div className="w-full bg-gray-200 rounded-full h-2 mt-3">
                <div 
                  className="bg-pink-500 h-2 rounded-full transition-all duration-500"
                  style={{ width: `${(vendors.filter(v => v.status === 'booked').length / vendors.length) * 100}%` }}
                ></div>
              </div>
            </div>
          </div>

          {/* Recent Activity & Upcoming Tasks */}
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between mb-4">
                <h3 className="font-semibold text-gray-900">Upcoming Tasks</h3>
                <button 
                  onClick={() => setShowTaskModal(true)}
                  className="text-pink-600 hover:text-pink-700 text-sm font-medium"
                >
                  Add Task
                </button>
              </div>
              <div className="space-y-3">
                {tasks
                  .filter(task => !task.completed)
                  .slice(0, 5)
                  .map((task) => (
                    <div key={task.id} className="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                      <div className="w-4 h-4 border-2 border-gray-300 rounded"></div>
                      <div className="flex-1">
                        <div className="font-medium text-gray-900 text-sm">{task.title}</div>
                        <div className="flex items-center space-x-2 mt-1">
                          <div className="text-xs text-gray-500">Due: {task.dueDate}</div>
                          <span className={`px-2 py-1 rounded-full text-xs font-medium ${getPriorityColor(task.priority)}`}>
                            {task.priority}
                          </span>
                        </div>
                      </div>
                      <Clock className="h-4 w-4 text-gray-400" />
                    </div>
                  ))}
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="font-semibold text-gray-900 mb-4">Vendor Status</h3>
              <div className="space-y-3">
                {vendors.map((vendor) => (
                  <div key={vendor.id} className="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <img src={vendor.image} alt={vendor.name} className="w-10 h-10 rounded-lg object-cover" />
                    <div className="flex-1">
                      <div className="font-medium text-gray-900 text-sm">{vendor.name}</div>
                      <div className="text-xs text-gray-500">{vendor.category}</div>
                    </div>
                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${getStatusColor(vendor.status)}`}>
                      {vendor.status}
                    </span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'budget' && (
        <div className="space-y-8">
          {/* Budget Overview */}
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">Budget Summary</h3>
              <div className="space-y-4">
                <div className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                  <span className="text-gray-600">Total Budget</span>
                  <span className="font-bold text-gray-900">R{totalBudget.toLocaleString()}</span>
                </div>
                <div className="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                  <span className="text-blue-700">Total Spent</span>
                  <span className="font-bold text-blue-800">R{totalSpent.toLocaleString()}</span>
                </div>
                <div className="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                  <span className="text-green-700">Remaining</span>
                  <span className="font-bold text-green-800">R{(totalBudget - totalSpent).toLocaleString()}</span>
                </div>
                <div className="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                  <span className="text-purple-700">Budget Used</span>
                  <span className="font-bold text-purple-800">{((totalSpent / totalBudget) * 100).toFixed(1)}%</span>
                </div>
              </div>
            </div>

            <div className="lg:col-span-2 bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between mb-6">
                <h3 className="text-lg font-semibold text-gray-900">Budget Breakdown</h3>
                <div className="flex space-x-2">
                  <button className="px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors">
                    <Download className="h-4 w-4 inline mr-2" />
                    Export
                  </button>
                  <button className="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <Edit className="h-4 w-4 inline mr-2" />
                    Edit Budget
                  </button>
                </div>
              </div>
              <div className="space-y-4">
                {budgetCategories.map((category) => {
                  const percentage = (category.spent / category.budgeted) * 100;
                  const isOverBudget = category.spent > category.budgeted;
                  return (
                    <div key={category.name} className="space-y-2">
                      <div className="flex justify-between items-center">
                        <span className="font-medium text-gray-700">{category.name}</span>
                        <div className="flex items-center space-x-2">
                          <span className="text-sm text-gray-600">
                            R{category.spent.toLocaleString()} / R{category.budgeted.toLocaleString()}
                          </span>
                          {isOverBudget && <AlertCircle className="h-4 w-4 text-red-500" />}
                        </div>
                      </div>
                      <div className="w-full bg-gray-200 rounded-full h-3">
                        <div
                          className={`h-3 rounded-full transition-all duration-500 ${
                            isOverBudget ? 'bg-red-500' : colorMap[category.color] || 'bg-gray-500'
                          }`}
                          style={{ width: `${Math.min(percentage, 100)}%` }}
                        ></div>
                      </div>
                      <div className="flex justify-between text-xs text-gray-500">
                        <span>{percentage.toFixed(1)}% used</span>
                        <span>R{(category.budgeted - category.spent).toLocaleString()} remaining</span>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'vendors' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <h3 className="text-xl font-semibold text-gray-900">Your Wedding Vendors</h3>
            <button className="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:from-pink-600 hover:to-purple-700 transition-all duration-200">
              <Plus className="h-4 w-4 inline mr-2" />
              Find Vendors
            </button>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            {vendors.map((vendor) => (
              <div key={vendor.id} className="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div className="flex items-center space-x-4 mb-4">
                  <img src={vendor.image} alt={vendor.name} className="w-16 h-16 rounded-lg object-cover" />
                  <div className="flex-1">
                    <h4 className="font-semibold text-gray-900">{vendor.name}</h4>
                    <p className="text-sm text-gray-600">{vendor.category}</p>
                    <div className="flex items-center space-x-1 mt-1">
                      <Star className="h-4 w-4 text-yellow-500 fill-current" />
                      <span className="text-sm text-gray-600">{vendor.rating}</span>
                    </div>
                  </div>
                  <span className={`px-3 py-1 rounded-full text-xs font-medium ${getStatusColor(vendor.status)}`}>
                    {vendor.status}
                  </span>
                </div>

                <div className="space-y-3">
                  <div className="flex justify-between items-center">
                    <span className="text-sm text-gray-600">Total Cost</span>
                    <span className="font-medium text-gray-900">R{vendor.price.toLocaleString()}</span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-sm text-gray-600">Paid</span>
                    <span className="font-medium text-green-600">R{vendor.paid.toLocaleString()}</span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-sm text-gray-600">Remaining</span>
                    <span className="font-medium text-red-600">R{(vendor.price - vendor.paid).toLocaleString()}</span>
                  </div>
                  
                  {vendor.nextPayment && (
                    <div className="flex justify-between items-center p-2 bg-yellow-50 rounded-lg">
                      <span className="text-sm text-yellow-700">Next Payment</span>
                      <span className="text-sm font-medium text-yellow-800">{vendor.nextPayment}</span>
                    </div>
                  )}
                </div>

                <div className="flex space-x-2 mt-4">
                  <button 
                    onClick={() => {
                      setSelectedVendor(vendor);
                      setShowVendorModal(true);
                    }}
                    className="flex-1 bg-pink-500 text-white py-2 rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors"
                  >
                    View Details
                  </button>
                  <button className="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <Phone className="h-4 w-4" />
                  </button>
                  <button className="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <Mail className="h-4 w-4" />
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      )}

      {selectedTab === 'guests' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-xl font-semibold text-gray-900">Guest Management</h3>
              <p className="text-gray-600">Track RSVPs and manage your guest list</p>
            </div>
            <div className="flex space-x-3">
              <button className="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                <Download className="h-4 w-4 inline mr-2" />
                Export List
              </button>
              <button className="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:from-pink-600 hover:to-purple-700 transition-all duration-200">
                <Plus className="h-4 w-4 inline mr-2" />
                Add Guest
              </button>
            </div>
          </div>

          {/* Guest Stats */}
          <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div className="bg-white rounded-lg p-4 shadow-sm">
              <div className="text-2xl font-bold text-gray-900">{guests.length}</div>
              <div className="text-sm text-gray-600">Total Invited</div>
            </div>
            <div className="bg-white rounded-lg p-4 shadow-sm">
              <div className="text-2xl font-bold text-green-600">{guests.filter(g => g.rsvpStatus === 'attending').length}</div>
              <div className="text-sm text-gray-600">Attending</div>
            </div>
            <div className="bg-white rounded-lg p-4 shadow-sm">
              <div className="text-2xl font-bold text-red-600">{guests.filter(g => g.rsvpStatus === 'declined').length}</div>
              <div className="text-sm text-gray-600">Declined</div>
            </div>
            <div className="bg-white rounded-lg p-4 shadow-sm">
              <div className="text-2xl font-bold text-yellow-600">{guests.filter(g => g.rsvpStatus === 'pending').length}</div>
              <div className="text-sm text-gray-600">Pending</div>
            </div>
          </div>

          {/* Guest List */}
          <div className="bg-white rounded-xl shadow-sm overflow-hidden">
            <div className="p-6 border-b border-gray-200">
              <div className="flex items-center space-x-4">
                <div className="relative flex-1">
                  <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                  <input
                    type="text"
                    placeholder="Search guests..."
                    className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                  />
                </div>
                <button className="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                  <Filter className="h-4 w-4 inline mr-2" />
                  Filter
                </button>
              </div>
            </div>
            
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RSVP Status</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plus One</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  {guests.map((guest) => (
                    <tr key={guest.id} className="hover:bg-gray-50">
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="font-medium text-gray-900">{guest.name}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm text-gray-600">{guest.email}</div>
                        <div className="text-sm text-gray-500">{guest.phone}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                          {guest.group}
                        </span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className={`px-2 py-1 rounded-full text-xs font-medium ${getRsvpColor(guest.rsvpStatus)}`}>
                          {guest.rsvpStatus}
                        </span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                          guest.plusOne ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'
                        }`}>
                          {guest.plusOne ? 'Yes' : 'No'}
                        </span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button className="text-pink-600 hover:text-pink-900 mr-3">Edit</button>
                        <button className="text-red-600 hover:text-red-900">Remove</button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'timeline' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <h3 className="text-xl font-semibold text-gray-900">Wedding Timeline</h3>
            <button 
              onClick={() => setShowTaskModal(true)}
              className="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:from-pink-600 hover:to-purple-700 transition-all duration-200"
            >
              <Plus className="h-4 w-4 inline mr-2" />
              Add Task
            </button>
          </div>

          <div className="bg-white rounded-xl p-6 shadow-sm">
            <div className="space-y-4">
              {tasks.map((task) => (
                <div key={task.id} className="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                  <div className={`w-6 h-6 rounded-full border-2 flex items-center justify-center ${
                    task.completed 
                      ? 'bg-green-500 border-green-500' 
                      : 'border-gray-300 hover:border-pink-500'
                  }`}>
                    {task.completed && <CheckCircle className="h-4 w-4 text-white" />}
                  </div>
                  <div className="flex-1">
                    <div className={`font-medium ${
                      task.completed ? 'text-gray-500 line-through' : 'text-gray-900'
                    }`}>
                      {task.title}
                    </div>
                    <div className="flex items-center space-x-3 mt-1">
                      <span className="text-sm text-gray-500">Due: {task.dueDate}</span>
                      <span className={`px-2 py-1 rounded-full text-xs font-medium ${getPriorityColor(task.priority)}`}>
                        {task.priority}
                      </span>
                      <span className="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                        {task.category}
                      </span>
                    </div>
                  </div>
                  <div className="flex items-center space-x-2">
                    <button className="p-2 text-gray-400 hover:text-pink-600 transition-colors">
                      <Edit className="h-4 w-4" />
                    </button>
                    <Clock className="h-5 w-5 text-gray-400" />
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'inspiration' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-xl font-semibold text-gray-900">Wedding Inspiration</h3>
              <p className="text-gray-600">Save ideas and create mood boards for your special day</p>
            </div>
            <button className="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:from-pink-600 hover:to-purple-700 transition-all duration-200">
              <Plus className="h-4 w-4 inline mr-2" />
              Add Inspiration
            </button>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {/* Inspiration boards would go here */}
            <div className="bg-white rounded-xl p-6 shadow-sm text-center">
              <Sparkles className="h-12 w-12 text-pink-500 mx-auto mb-4" />
              <h4 className="font-semibold text-gray-900 mb-2">Create Your First Board</h4>
              <p className="text-gray-600 text-sm mb-4">Start collecting inspiration for your dream wedding</p>
              <button className="bg-pink-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors">
                Get Started
              </button>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'documents' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-xl font-semibold text-gray-900">Wedding Documents</h3>
              <p className="text-gray-600">Store and organize all your wedding-related documents</p>
            </div>
            <button className="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:from-pink-600 hover:to-purple-700 transition-all duration-200">
              <Plus className="h-4 w-4 inline mr-2" />
              Upload Document
            </button>
          </div>

          <div className="bg-white rounded-xl p-6 shadow-sm text-center">
            <FileText className="h-12 w-12 text-gray-400 mx-auto mb-4" />
            <h4 className="font-semibold text-gray-900 mb-2">No Documents Yet</h4>
            <p className="text-gray-600 text-sm mb-4">Upload contracts, receipts, and other important documents</p>
            <button className="bg-pink-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors">
              Upload First Document
            </button>
          </div>
        </div>
      )}

      {selectedTab === 'settings' && (
        <div className="space-y-6">
          <h3 className="text-xl font-semibold text-gray-900">Wedding Settings</h3>
          
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Wedding Details</h4>
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Wedding Date</label>
                  <input type="date" value="2025-06-15" className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Venue</label>
                  <input type="text" value="Riverside Garden Estate" className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Wedding Style</label>
                  <select className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                    <option>Garden Party</option>
                    <option>Classic Elegance</option>
                    <option>Modern Chic</option>
                    <option>Rustic Charm</option>
                  </select>
                </div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Notifications</h4>
              <div className="space-y-4">
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-700">Task Reminders</span>
                  <button className="w-12 h-6 bg-pink-500 rounded-full relative">
                    <div className="w-5 h-5 bg-white rounded-full absolute right-0.5 top-0.5"></div>
                  </button>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-700">Payment Reminders</span>
                  <button className="w-12 h-6 bg-pink-500 rounded-full relative">
                    <div className="w-5 h-5 bg-white rounded-full absolute right-0.5 top-0.5"></div>
                  </button>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-700">RSVP Updates</span>
                  <button className="w-12 h-6 bg-gray-300 rounded-full relative">
                    <div className="w-5 h-5 bg-white rounded-full absolute left-0.5 top-0.5"></div>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Vendor Detail Modal */}
      {showVendorModal && selectedVendor && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div className="p-6">
              <div className="flex justify-between items-center mb-6">
                <h3 className="text-xl font-bold text-gray-900">Vendor Details</h3>
                <button
                  onClick={() => setShowVendorModal(false)}
                  className="p-2 hover:bg-gray-100 rounded-full transition-colors"
                >
                  <X className="h-5 w-5 text-gray-500" />
                </button>
              </div>

              <div className="space-y-6">
                <div className="flex items-center space-x-4">
                  <img src={selectedVendor.image} alt={selectedVendor.name} className="w-20 h-20 rounded-xl object-cover" />
                  <div>
                    <h4 className="text-lg font-semibold text-gray-900">{selectedVendor.name}</h4>
                    <p className="text-gray-600">{selectedVendor.category}</p>
                    <div className="flex items-center space-x-1 mt-1">
                      <Star className="h-4 w-4 text-yellow-500 fill-current" />
                      <span className="text-sm text-gray-600">{selectedVendor.rating} rating</span>
                    </div>
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div className="p-4 bg-gray-50 rounded-lg">
                    <div className="text-sm text-gray-600">Total Cost</div>
                    <div className="text-lg font-semibold text-gray-900">R{selectedVendor.price.toLocaleString()}</div>
                  </div>
                  <div className="p-4 bg-green-50 rounded-lg">
                    <div className="text-sm text-green-600">Amount Paid</div>
                    <div className="text-lg font-semibold text-green-700">R{selectedVendor.paid.toLocaleString()}</div>
                  </div>
                </div>

                <div className="space-y-3">
                  <div className="flex justify-between">
                    <span className="text-gray-600">Status</span>
                    <span className={`px-3 py-1 rounded-full text-sm font-medium ${getStatusColor(selectedVendor.status)}`}>
                      {selectedVendor.status}
                    </span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-gray-600">Contact</span>
                    <span className="text-gray-900">{selectedVendor.contact}</span>
                  </div>
                  {selectedVendor.nextPayment && (
                    <div className="flex justify-between">
                      <span className="text-gray-600">Next Payment Due</span>
                      <span className="text-red-600 font-medium">{selectedVendor.nextPayment}</span>
                    </div>
                  )}
                </div>

                <div className="flex space-x-3">
                  <button className="flex-1 bg-pink-500 text-white py-3 rounded-lg font-medium hover:bg-pink-600 transition-colors">
                    <MessageCircle className="h-4 w-4 inline mr-2" />
                    Message
                  </button>
                  <button className="flex-1 border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    <Phone className="h-4 w-4 inline mr-2" />
                    Call
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default CouplesDashboard;
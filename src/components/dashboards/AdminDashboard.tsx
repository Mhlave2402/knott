import React, { useState } from 'react';
import { Users, TrendingUp, DollarSign, Shield, AlertTriangle, Crown, Eye, CreditCard as Edit, Trash2, Search, Filter, BarChart3, UserCheck, UserX, MapPin, Calendar, Star, Heart, ShoppingBag, Briefcase, MessageSquare, Flag, Ban, CheckCircle, XCircle, Download, Upload, Settings, Bell, Activity, CreditCard, Globe, Zap, Target, Award, TrendingDown, Plus, Mail, Phone } from 'lucide-react';

interface AdminDashboardProps {
  userName: string;
}

interface User {
  id: string;
  name: string;
  email: string;
  phone?: string;
  role: 'couple' | 'pro' | 'venue' | 'negotiator' | 'guest' | 'seller';
  status: 'active' | 'suspended' | 'pending' | 'banned';
  joinDate: string;
  lastActive: string;
  verified: boolean;
  premium: boolean;
  location: string;
  revenue?: number;
  bookings?: number;
  rating?: number;
  profileCompletion: number;
}

interface Transaction {
  id: string;
  user: string;
  type: 'booking' | 'subscription' | 'commission' | 'refund';
  amount: number;
  status: 'completed' | 'pending' | 'failed';
  date: string;
  description: string;
}

interface Report {
  id: string;
  reporter: string;
  reported: string;
  type: 'inappropriate_content' | 'fake_profile' | 'spam' | 'harassment' | 'other';
  description: string;
  status: 'pending' | 'resolved' | 'dismissed';
  date: string;
  priority: 'low' | 'medium' | 'high';
}

const mockUsers: User[] = [
  {
    id: '1',
    name: 'John & Sarah Miller',
    email: 'john.sarah@email.com',
    phone: '+27 11 123 4567',
    role: 'couple',
    status: 'active',
    joinDate: '2024-01-15',
    lastActive: '2025-01-10',
    verified: true,
    premium: false,
    location: 'Cape Town, WC',
    bookings: 3,
    profileCompletion: 85
  },
  {
    id: '2',
    name: 'Elegant Memories Photography',
    email: 'info@elegantmemories.co.za',
    phone: '+27 21 456 7890',
    role: 'pro',
    status: 'active',
    joinDate: '2023-08-20',
    lastActive: '2025-01-09',
    verified: true,
    premium: true,
    location: 'Cape Town, WC',
    revenue: 125000,
    bookings: 23,
    rating: 4.9,
    profileCompletion: 95
  },
  {
    id: '3',
    name: 'Riverside Garden Estate',
    email: 'bookings@riverside.co.za',
    phone: '+27 21 789 0123',
    role: 'venue',
    status: 'active',
    joinDate: '2023-05-10',
    lastActive: '2025-01-08',
    verified: true,
    premium: true,
    location: 'Stellenbosch, WC',
    revenue: 280000,
    bookings: 18,
    rating: 4.8,
    profileCompletion: 90
  },
  {
    id: '4',
    name: 'Themba Mthembu',
    email: 'themba@negotiations.co.za',
    phone: '+27 11 234 5678',
    role: 'negotiator',
    status: 'active',
    joinDate: '2024-03-05',
    lastActive: '2025-01-07',
    verified: true,
    premium: false,
    location: 'Johannesburg, GP',
    revenue: 45000,
    bookings: 7,
    rating: 4.9,
    profileCompletion: 80
  },
  {
    id: '5',
    name: 'Lisa Thompson',
    email: 'lisa.t@email.com',
    phone: '+27 31 345 6789',
    role: 'seller',
    status: 'pending',
    joinDate: '2025-01-05',
    lastActive: '2025-01-06',
    verified: false,
    premium: false,
    location: 'Durban, KZN',
    profileCompletion: 45
  },
  {
    id: '6',
    name: 'Suspicious User',
    email: 'fake@example.com',
    role: 'pro',
    status: 'banned',
    joinDate: '2024-12-01',
    lastActive: '2024-12-15',
    verified: false,
    premium: false,
    location: 'Unknown',
    profileCompletion: 20
  }
];

const mockTransactions: Transaction[] = [
  {
    id: '1',
    user: 'Elegant Memories Photography',
    type: 'booking',
    amount: 22000,
    status: 'completed',
    date: '2025-01-10',
    description: 'Wedding photography booking - John & Sarah'
  },
  {
    id: '2',
    user: 'Riverside Garden Estate',
    type: 'booking',
    amount: 45000,
    status: 'completed',
    date: '2025-01-09',
    description: 'Venue booking - Mike & Emma wedding'
  },
  {
    id: '3',
    user: 'Elegant Memories Photography',
    type: 'subscription',
    amount: 299,
    status: 'completed',
    date: '2025-01-08',
    description: 'Premium subscription renewal'
  },
  {
    id: '4',
    user: 'New Pro Studio',
    type: 'commission',
    amount: 1500,
    status: 'pending',
    date: '2025-01-07',
    description: 'Platform commission - December bookings'
  }
];

const mockReports: Report[] = [
  {
    id: '1',
    reporter: 'John Miller',
    reported: 'Suspicious User',
    type: 'fake_profile',
    description: 'Profile uses stolen photos and fake credentials',
    status: 'pending',
    date: '2025-01-10',
    priority: 'high'
  },
  {
    id: '2',
    reporter: 'Sarah Wilson',
    reported: 'Bad Vendor Co',
    type: 'inappropriate_content',
    description: 'Posting inappropriate images in portfolio',
    status: 'resolved',
    date: '2025-01-09',
    priority: 'medium'
  },
  {
    id: '3',
    reporter: 'Anonymous',
    reported: 'Spam Account',
    type: 'spam',
    description: 'Sending unsolicited messages to multiple users',
    status: 'pending',
    date: '2025-01-08',
    priority: 'low'
  }
];

const AdminDashboard: React.FC<AdminDashboardProps> = ({ userName }) => {
  const [selectedTab, setSelectedTab] = useState('overview');
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedRole, setSelectedRole] = useState('all');
  const [selectedStatus, setSelectedStatus] = useState('all');
  const [showUserModal, setShowUserModal] = useState(false);
  const [selectedUser, setSelectedUser] = useState<User | null>(null);
  const [showBulkActions, setShowBulkActions] = useState(false);
  const [selectedUsers, setSelectedUsers] = useState<string[]>([]);

  const tabs = [
    { id: 'overview', label: 'Overview', icon: BarChart3 },
    { id: 'users', label: 'User Management', icon: Users },
    { id: 'financial', label: 'Financial', icon: DollarSign },
    { id: 'reports', label: 'Reports & Moderation', icon: Flag },
    { id: 'analytics', label: 'Analytics', icon: TrendingUp },
    { id: 'settings', label: 'Platform Settings', icon: Settings }
  ];

  const stats = [
    { label: 'Total Users', value: '2,847', icon: Users, color: 'blue', change: '+12%', trend: 'up' },
    { label: 'Monthly Revenue', value: 'R485,600', icon: DollarSign, color: 'green', change: '+8%', trend: 'up' },
    { label: 'Active Bookings', value: '156', icon: Calendar, color: 'purple', change: '+15%', trend: 'up' },
    { label: 'Platform Rating', value: '4.8', icon: Star, color: 'yellow', change: '+0.2', trend: 'up' },
    { label: 'Pending Reports', value: '12', icon: Flag, color: 'red', change: '+3', trend: 'up' },
    { label: 'Conversion Rate', value: '3.2%', icon: Target, color: 'indigo', change: '-0.1%', trend: 'down' }
  ];

  const roleStats = [
    { role: 'couple', count: 1245, icon: Heart, color: 'pink', revenue: 0, growth: '+15%' },
    { role: 'pro', count: 892, icon: Briefcase, color: 'blue', revenue: 2450000, growth: '+8%' },
    { role: 'venue', count: 234, icon: MapPin, color: 'green', revenue: 1890000, growth: '+12%' },
    { role: 'negotiator', count: 156, icon: Users, color: 'purple', revenue: 340000, growth: '+22%' },
    { role: 'seller', count: 320, icon: ShoppingBag, color: 'teal', revenue: 125000, growth: '+5%' }
  ];

  const filteredUsers = mockUsers.filter(user => {
    const matchesSearch = user.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         user.email.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesRole = selectedRole === 'all' || user.role === selectedRole;
    const matchesStatus = selectedStatus === 'all' || user.status === selectedStatus;
    return matchesSearch && matchesRole && matchesStatus;
  });

  const getRoleIcon = (role: string) => {
    switch (role) {
      case 'couple': return Heart;
      case 'pro': return Briefcase;
      case 'venue': return MapPin;
      case 'negotiator': return Users;
      case 'seller': return ShoppingBag;
      default: return Users;
    }
  };

  const getRoleColor = (role: string) => {
    switch (role) {
      case 'couple': return 'pink';
      case 'pro': return 'blue';
      case 'venue': return 'green';
      case 'negotiator': return 'purple';
      case 'seller': return 'teal';
      default: return 'gray';
    }
  };

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'active': return 'green';
      case 'suspended': return 'yellow';
      case 'pending': return 'blue';
      case 'banned': return 'red';
      default: return 'gray';
    }
  };

  const handleUserAction = (action: string, userId: string) => {
    const user = mockUsers.find(u => u.id === userId);
    if (user) {
      switch (action) {
        case 'view':
          setSelectedUser(user);
          setShowUserModal(true);
          break;
        case 'suspend':
          console.log(`Suspending user ${userId}`);
          break;
        case 'ban':
          console.log(`Banning user ${userId}`);
          break;
        case 'verify':
          console.log(`Verifying user ${userId}`);
          break;
        case 'delete':
          console.log(`Deleting user ${userId}`);
          break;
      }
    }
  };

  const handleBulkAction = (action: string) => {
    console.log(`Performing ${action} on users:`, selectedUsers);
    setSelectedUsers([]);
    setShowBulkActions(false);
  };

  return (
    <div className="p-6">
      {/* Header */}
      <div className="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-6 text-white mb-8">
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold mb-2">Welcome back, {userName}! 👑</h1>
            <p className="text-indigo-100">Knott Platform Administration</p>
          </div>
          <div className="flex items-center space-x-4">
            <div className="text-center">
              <div className="text-2xl font-bold">99.9%</div>
              <div className="text-sm text-indigo-100">Uptime</div>
            </div>
            <div className="flex items-center space-x-2">
              <Shield className="h-6 w-6 text-yellow-400" />
              <span className="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">Super Admin</span>
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
                    ? 'bg-indigo-600 text-white shadow-md'
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
          {/* Enhanced Stats Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {stats.map((stat) => {
              const Icon = stat.icon;
              const TrendIcon = stat.trend === 'up' ? TrendingUp : TrendingDown;
              return (
                <div key={stat.label} className="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                  <div className="flex items-center justify-between mb-4">
                    <div className={`w-12 h-12 bg-${stat.color}-100 rounded-lg flex items-center justify-center`}>
                      <Icon className={`h-6 w-6 text-${stat.color}-600`} />
                    </div>
                    <div className={`flex items-center space-x-1 text-sm font-medium ${
                      stat.trend === 'up' ? 'text-green-600' : 'text-red-600'
                    }`}>
                      <TrendIcon className="h-4 w-4" />
                      <span>{stat.change}</span>
                    </div>
                  </div>
                  <div className="text-3xl font-bold text-gray-900 mb-1">{stat.value}</div>
                  <div className="text-sm text-gray-600">{stat.label}</div>
                </div>
              );
            })}
          </div>

          {/* Enhanced Role Distribution */}
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="text-lg font-semibold text-gray-900 mb-6">User Distribution & Revenue</h3>
              <div className="space-y-4">
                {roleStats.map((role) => {
                  const Icon = role.icon;
                  const total = roleStats.reduce((sum, r) => sum + r.count, 0);
                  const percentage = ((role.count / total) * 100).toFixed(1);
                  return (
                    <div key={role.role} className="space-y-2">
                      <div className="flex items-center justify-between">
                        <div className="flex items-center space-x-3">
                          <div className={`w-8 h-8 bg-${role.color}-100 rounded-lg flex items-center justify-center`}>
                            <Icon className={`h-4 w-4 text-${role.color}-600`} />
                          </div>
                          <div>
                            <span className="font-medium text-gray-700 capitalize">{role.role}s</span>
                            <div className="text-xs text-green-600 font-medium">{role.growth}</div>
                          </div>
                        </div>
                        <div className="text-right">
                          <div className="flex items-center space-x-3">
                            <span className="text-sm text-gray-500">{percentage}%</span>
                            <span className="font-semibold text-gray-900">{role.count.toLocaleString()}</span>
                          </div>
                          {role.revenue > 0 && (
                            <div className="text-xs text-gray-500">R{role.revenue.toLocaleString()}</div>
                          )}
                        </div>
                      </div>
                      <div className="w-full bg-gray-200 rounded-full h-2">
                        <div
                          className={`bg-${role.color}-500 h-2 rounded-full transition-all duration-500`}
                          style={{ width: `${percentage}%` }}
                        ></div>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>

            {/* Real-time Activity Feed */}
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between mb-6">
                <h3 className="text-lg font-semibold text-gray-900">Live Activity Feed</h3>
                <div className="flex items-center space-x-2">
                  <div className="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                  <span className="text-sm text-green-600">Live</span>
                </div>
              </div>
              <div className="space-y-4 max-h-80 overflow-y-auto">
                <div className="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                  <UserCheck className="h-5 w-5 text-green-600" />
                  <div className="flex-1">
                    <div className="text-sm font-medium text-gray-900">New Pro Verified</div>
                    <div className="text-xs text-gray-500">Elegant Memories Photography approved</div>
                  </div>
                  <div className="text-xs text-gray-400">2m ago</div>
                </div>
                <div className="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                  <DollarSign className="h-5 w-5 text-blue-600" />
                  <div className="flex-1">
                    <div className="text-sm font-medium text-gray-900">High Value Booking</div>
                    <div className="text-xs text-gray-500">R45,000 venue booking completed</div>
                  </div>
                  <div className="text-xs text-gray-400">5m ago</div>
                </div>
                <div className="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg">
                  <AlertTriangle className="h-5 w-5 text-yellow-600" />
                  <div className="flex-1">
                    <div className="text-sm font-medium text-gray-900">Review Flagged</div>
                    <div className="text-xs text-gray-500">Inappropriate content reported</div>
                  </div>
                  <div className="text-xs text-gray-400">8m ago</div>
                </div>
                <div className="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg">
                  <Crown className="h-5 w-5 text-purple-600" />
                  <div className="flex-1">
                    <div className="text-sm font-medium text-gray-900">Premium Upgrade</div>
                    <div className="text-xs text-gray-500">Riverside Garden Estate upgraded</div>
                  </div>
                  <div className="text-xs text-gray-400">12m ago</div>
                </div>
                <div className="flex items-center space-x-3 p-3 bg-red-50 rounded-lg">
                  <Ban className="h-5 w-5 text-red-600" />
                  <div className="flex-1">
                    <div className="text-sm font-medium text-gray-900">User Suspended</div>
                    <div className="text-xs text-gray-500">Suspicious activity detected</div>
                  </div>
                  <div className="text-xs text-gray-400">15m ago</div>
                </div>
              </div>
            </div>
          </div>

          {/* Quick Actions */}
          <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button className="bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow text-left">
              <Plus className="h-8 w-8 text-blue-600 mb-2" />
              <div className="font-medium text-gray-900">Add New User</div>
              <div className="text-sm text-gray-500">Create admin account</div>
            </button>
            <button className="bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow text-left">
              <Download className="h-8 w-8 text-green-600 mb-2" />
              <div className="font-medium text-gray-900">Export Data</div>
              <div className="text-sm text-gray-500">Download reports</div>
            </button>
            <button className="bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow text-left">
              <Bell className="h-8 w-8 text-yellow-600 mb-2" />
              <div className="font-medium text-gray-900">Send Notification</div>
              <div className="text-sm text-gray-500">Broadcast message</div>
            </button>
            <button className="bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow text-left">
              <Settings className="h-8 w-8 text-purple-600 mb-2" />
              <div className="font-medium text-gray-900">Platform Settings</div>
              <div className="text-sm text-gray-500">Configure system</div>
            </button>
          </div>
        </div>
      )}

      {selectedTab === 'users' && (
        <div className="space-y-6">
          {/* Enhanced Search and Filters */}
          <div className="bg-white rounded-xl p-6 shadow-sm">
            <div className="flex flex-col lg:flex-row gap-4 mb-4">
              <div className="relative flex-1">
                <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                <input
                  type="text"
                  placeholder="Search users by name, email, or phone..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                />
              </div>
              <select
                value={selectedRole}
                onChange={(e) => setSelectedRole(e.target.value)}
                className="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500"
              >
                <option value="all">All Roles</option>
                <option value="couple">Couples</option>
                <option value="pro">Pros</option>
                <option value="venue">Venues</option>
                <option value="negotiator">Negotiators</option>
                <option value="seller">Sellers</option>
              </select>
              <select
                value={selectedStatus}
                onChange={(e) => setSelectedStatus(e.target.value)}
                className="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500"
              >
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="pending">Pending</option>
                <option value="suspended">Suspended</option>
                <option value="banned">Banned</option>
              </select>
              <button
                onClick={() => setShowBulkActions(!showBulkActions)}
                className="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors"
              >
                Bulk Actions
              </button>
            </div>

            {/* Bulk Actions */}
            {showBulkActions && selectedUsers.length > 0 && (
              <div className="bg-indigo-50 p-4 rounded-lg mb-4">
                <div className="flex items-center justify-between">
                  <span className="text-sm font-medium text-indigo-900">
                    {selectedUsers.length} users selected
                  </span>
                  <div className="flex space-x-2">
                    <button
                      onClick={() => handleBulkAction('verify')}
                      className="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700"
                    >
                      Verify
                    </button>
                    <button
                      onClick={() => handleBulkAction('suspend')}
                      className="px-3 py-1 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700"
                    >
                      Suspend
                    </button>
                    <button
                      onClick={() => handleBulkAction('delete')}
                      className="px-3 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700"
                    >
                      Delete
                    </button>
                  </div>
                </div>
              </div>
            )}
          </div>

          {/* Enhanced Users Table */}
          <div className="bg-white rounded-xl shadow-sm overflow-hidden">
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left">
                      <input
                        type="checkbox"
                        onChange={(e) => {
                          if (e.target.checked) {
                            setSelectedUsers(filteredUsers.map(u => u.id));
                          } else {
                            setSelectedUsers([]);
                          }
                        }}
                        className="rounded border-gray-300"
                      />
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  {filteredUsers.map((user) => {
                    const RoleIcon = getRoleIcon(user.role);
                    return (
                      <tr key={user.id} className="hover:bg-gray-50">
                        <td className="px-6 py-4">
                          <input
                            type="checkbox"
                            checked={selectedUsers.includes(user.id)}
                            onChange={(e) => {
                              if (e.target.checked) {
                                setSelectedUsers([...selectedUsers, user.id]);
                              } else {
                                setSelectedUsers(selectedUsers.filter(id => id !== user.id));
                              }
                            }}
                            className="rounded border-gray-300"
                          />
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap">
                          <div className="flex items-center">
                            <div className="flex-shrink-0 h-12 w-12">
                              <div className={`h-12 w-12 bg-${getRoleColor(user.role)}-100 rounded-full flex items-center justify-center`}>
                                <RoleIcon className={`h-6 w-6 text-${getRoleColor(user.role)}-600`} />
                              </div>
                            </div>
                            <div className="ml-4">
                              <div className="text-sm font-medium text-gray-900 flex items-center space-x-2">
                                <span>{user.name}</span>
                                {user.verified && <UserCheck className="h-4 w-4 text-blue-500" />}
                                {user.premium && <Crown className="h-4 w-4 text-yellow-500" />}
                              </div>
                              <div className="text-sm text-gray-500">{user.email}</div>
                              <div className="text-xs text-gray-400">{user.location}</div>
                            </div>
                          </div>
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap">
                          <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-${getRoleColor(user.role)}-100 text-${getRoleColor(user.role)}-800 capitalize`}>
                            {user.role}
                          </span>
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap">
                          <div className="space-y-1">
                            <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-${getStatusColor(user.status)}-100 text-${getStatusColor(user.status)}-800 capitalize`}>
                              {user.status}
                            </span>
                            <div className="w-full bg-gray-200 rounded-full h-1">
                              <div
                                className="bg-blue-500 h-1 rounded-full"
                                style={{ width: `${user.profileCompletion}%` }}
                              ></div>
                            </div>
                            <div className="text-xs text-gray-500">{user.profileCompletion}% complete</div>
                          </div>
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap text-sm">
                          <div className="space-y-1">
                            {user.revenue && (
                              <div className="text-gray-900 font-medium">R{user.revenue.toLocaleString()}</div>
                            )}
                            {user.bookings && (
                              <div className="text-gray-500">{user.bookings} bookings</div>
                            )}
                            {user.rating && (
                              <div className="flex items-center space-x-1">
                                <Star className="h-3 w-3 text-yellow-500 fill-current" />
                                <span className="text-gray-600">{user.rating}</span>
                              </div>
                            )}
                          </div>
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          <div className="space-y-1">
                            <div className="flex items-center space-x-1">
                              <Mail className="h-3 w-3" />
                              <span className="truncate max-w-32">{user.email}</span>
                            </div>
                            {user.phone && (
                              <div className="flex items-center space-x-1">
                                <Phone className="h-3 w-3" />
                                <span>{user.phone}</span>
                              </div>
                            )}
                          </div>
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                          <div className="flex items-center space-x-2">
                            <button
                              onClick={() => handleUserAction('view', user.id)}
                              className="text-indigo-600 hover:text-indigo-900"
                              title="View Details"
                            >
                              <Eye className="h-4 w-4" />
                            </button>
                            <button
                              onClick={() => handleUserAction('verify', user.id)}
                              className="text-green-600 hover:text-green-900"
                              title="Verify User"
                            >
                              <CheckCircle className="h-4 w-4" />
                            </button>
                            <button
                              onClick={() => handleUserAction('suspend', user.id)}
                              className="text-yellow-600 hover:text-yellow-900"
                              title="Suspend User"
                            >
                              <XCircle className="h-4 w-4" />
                            </button>
                            <button
                              onClick={() => handleUserAction('ban', user.id)}
                              className="text-red-600 hover:text-red-900"
                              title="Ban User"
                            >
                              <Ban className="h-4 w-4" />
                            </button>
                          </div>
                        </td>
                      </tr>
                    );
                  })}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'financial' && (
        <div className="space-y-6">
          {/* Financial Overview */}
          <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3">
                <div className="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                  <DollarSign className="h-5 w-5 text-green-600" />
                </div>
                <div>
                  <div className="text-2xl font-bold text-gray-900">R485,600</div>
                  <div className="text-sm text-gray-600">Monthly Revenue</div>
                </div>
              </div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3">
                <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                  <CreditCard className="h-5 w-5 text-blue-600" />
                </div>
                <div>
                  <div className="text-2xl font-bold text-gray-900">R48,560</div>
                  <div className="text-sm text-gray-600">Platform Fees</div>
                </div>
              </div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3">
                <div className="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                  <Activity className="h-5 w-5 text-purple-600" />
                </div>
                <div>
                  <div className="text-2xl font-bold text-gray-900">156</div>
                  <div className="text-sm text-gray-600">Active Transactions</div>
                </div>
              </div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3">
                <div className="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                  <Award className="h-5 w-5 text-yellow-600" />
                </div>
                <div>
                  <div className="text-2xl font-bold text-gray-900">R12,340</div>
                  <div className="text-sm text-gray-600">Pending Payouts</div>
                </div>
              </div>
            </div>
          </div>

          {/* Recent Transactions */}
          <div className="bg-white rounded-xl p-6 shadow-sm">
            <div className="flex items-center justify-between mb-6">
              <h3 className="text-lg font-semibold text-gray-900">Recent Transactions</h3>
              <button className="flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                <Download className="h-4 w-4" />
                <span>Export</span>
              </button>
            </div>
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transaction</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-200">
                  {mockTransactions.map((transaction) => (
                    <tr key={transaction.id} className="hover:bg-gray-50">
                      <td className="px-6 py-4">
                        <div className="text-sm font-medium text-gray-900">{transaction.id}</div>
                        <div className="text-sm text-gray-500">{transaction.description}</div>
                      </td>
                      <td className="px-6 py-4 text-sm text-gray-900">{transaction.user}</td>
                      <td className="px-6 py-4">
                        <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                          transaction.type === 'booking' ? 'bg-blue-100 text-blue-800' :
                          transaction.type === 'subscription' ? 'bg-purple-100 text-purple-800' :
                          transaction.type === 'commission' ? 'bg-green-100 text-green-800' :
                          'bg-red-100 text-red-800'
                        }`}>
                          {transaction.type}
                        </span>
                      </td>
                      <td className="px-6 py-4 text-sm font-medium text-gray-900">
                        R{transaction.amount.toLocaleString()}
                      </td>
                      <td className="px-6 py-4">
                        <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                          transaction.status === 'completed' ? 'bg-green-100 text-green-800' :
                          transaction.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                          'bg-red-100 text-red-800'
                        }`}>
                          {transaction.status}
                        </span>
                      </td>
                      <td className="px-6 py-4 text-sm text-gray-500">{transaction.date}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'reports' && (
        <div className="space-y-6">
          {/* Reports Overview */}
          <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3">
                <div className="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                  <Flag className="h-5 w-5 text-red-600" />
                </div>
                <div>
                  <div className="text-2xl font-bold text-gray-900">12</div>
                  <div className="text-sm text-gray-600">Pending Reports</div>
                </div>
              </div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3">
                <div className="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                  <CheckCircle className="h-5 w-5 text-green-600" />
                </div>
                <div>
                  <div className="text-2xl font-bold text-gray-900">45</div>
                  <div className="text-sm text-gray-600">Resolved This Month</div>
                </div>
              </div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3">
                <div className="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                  <AlertTriangle className="h-5 w-5 text-yellow-600" />
                </div>
                <div>
                  <div className="text-2xl font-bold text-gray-900">3</div>
                  <div className="text-sm text-gray-600">High Priority</div>
                </div>
              </div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3">
                <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                  <Shield className="h-5 w-5 text-blue-600" />
                </div>
                <div>
                  <div className="text-2xl font-bold text-gray-900">98.5%</div>
                  <div className="text-sm text-gray-600">Resolution Rate</div>
                </div>
              </div>
            </div>
          </div>

          {/* Reports Table */}
          <div className="bg-white rounded-xl p-6 shadow-sm">
            <h3 className="text-lg font-semibold text-gray-900 mb-6">Content Moderation Reports</h3>
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Report</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-200">
                  {mockReports.map((report) => (
                    <tr key={report.id} className="hover:bg-gray-50">
                      <td className="px-6 py-4">
                        <div className="text-sm font-medium text-gray-900">
                          {report.reporter} → {report.reported}
                        </div>
                        <div className="text-sm text-gray-500">{report.description}</div>
                      </td>
                      <td className="px-6 py-4">
                        <span className="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                          {report.type.replace('_', ' ')}
                        </span>
                      </td>
                      <td className="px-6 py-4">
                        <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                          report.priority === 'high' ? 'bg-red-100 text-red-800' :
                          report.priority === 'medium' ? 'bg-yellow-100 text-yellow-800' :
                          'bg-green-100 text-green-800'
                        }`}>
                          {report.priority}
                        </span>
                      </td>
                      <td className="px-6 py-4">
                        <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                          report.status === 'resolved' ? 'bg-green-100 text-green-800' :
                          report.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                          'bg-gray-100 text-gray-800'
                        }`}>
                          {report.status}
                        </span>
                      </td>
                      <td className="px-6 py-4 text-sm text-gray-500">{report.date}</td>
                      <td className="px-6 py-4">
                        <div className="flex items-center space-x-2">
                          <button className="text-indigo-600 hover:text-indigo-900">
                            <Eye className="h-4 w-4" />
                          </button>
                          <button className="text-green-600 hover:text-green-900">
                            <CheckCircle className="h-4 w-4" />
                          </button>
                          <button className="text-red-600 hover:text-red-900">
                            <XCircle className="h-4 w-4" />
                          </button>
                        </div>
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
        <div className="bg-white rounded-xl p-6 shadow-sm">
          <h3 className="text-lg font-semibold text-gray-900 mb-6">Advanced Analytics Dashboard</h3>
          <div className="text-center py-12 text-gray-500">
            <BarChart3 className="h-12 w-12 mx-auto mb-4" />
            <p className="text-lg font-medium mb-2">Advanced Analytics Coming Soon</p>
            <p>Detailed insights, conversion funnels, and business intelligence tools</p>
          </div>
        </div>
      )}

      {selectedTab === 'settings' && (
        <div className="space-y-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">Platform Configuration</h3>
              <div className="space-y-4">
                <div className="flex items-center justify-between">
                  <span className="text-sm font-medium text-gray-700">User Registration</span>
                  <button className="bg-green-500 rounded-full w-12 h-6 flex items-center justify-end px-1">
                    <div className="bg-white w-4 h-4 rounded-full"></div>
                  </button>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm font-medium text-gray-700">Auto-Verification</span>
                  <button className="bg-gray-300 rounded-full w-12 h-6 flex items-center justify-start px-1">
                    <div className="bg-white w-4 h-4 rounded-full"></div>
                  </button>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm font-medium text-gray-700">Maintenance Mode</span>
                  <button className="bg-gray-300 rounded-full w-12 h-6 flex items-center justify-start px-1">
                    <div className="bg-white w-4 h-4 rounded-full"></div>
                  </button>
                </div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">System Health</h3>
              <div className="space-y-4">
                <div className="flex items-center justify-between">
                  <span className="text-sm font-medium text-gray-700">Server Status</span>
                  <span className="flex items-center space-x-2">
                    <div className="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span className="text-sm text-green-600">Healthy</span>
                  </span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm font-medium text-gray-700">Database</span>
                  <span className="flex items-center space-x-2">
                    <div className="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span className="text-sm text-green-600">Connected</span>
                  </span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm font-medium text-gray-700">Payment Gateway</span>
                  <span className="flex items-center space-x-2">
                    <div className="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span className="text-sm text-green-600">Active</span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* User Detail Modal */}
      {showUserModal && selectedUser && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div className="p-6">
              <div className="flex items-center justify-between mb-6">
                <h3 className="text-xl font-bold text-gray-900">User Details</h3>
                <button
                  onClick={() => setShowUserModal(false)}
                  className="p-2 hover:bg-gray-100 rounded-full"
                >
                  <XCircle className="h-5 w-5 text-gray-500" />
                </button>
              </div>

              <div className="space-y-6">
                <div className="flex items-center space-x-4">
                  <div className={`w-16 h-16 bg-${getRoleColor(selectedUser.role)}-100 rounded-full flex items-center justify-center`}>
                    {React.createElement(getRoleIcon(selectedUser.role), {
                      className: `h-8 w-8 text-${getRoleColor(selectedUser.role)}-600`
                    })}
                  </div>
                  <div>
                    <h4 className="text-lg font-semibold text-gray-900">{selectedUser.name}</h4>
                    <p className="text-gray-600">{selectedUser.email}</p>
                    <div className="flex items-center space-x-2 mt-1">
                      {selectedUser.verified && <UserCheck className="h-4 w-4 text-blue-500" />}
                      {selectedUser.premium && <Crown className="h-4 w-4 text-yellow-500" />}
                      <span className={`px-2 py-1 text-xs rounded-full bg-${getStatusColor(selectedUser.status)}-100 text-${getStatusColor(selectedUser.status)}-800`}>
                        {selectedUser.status}
                      </span>
                    </div>
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div>
                    <label className="text-sm font-medium text-gray-500">Role</label>
                    <p className="text-gray-900 capitalize">{selectedUser.role}</p>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-500">Location</label>
                    <p className="text-gray-900">{selectedUser.location}</p>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-500">Join Date</label>
                    <p className="text-gray-900">{selectedUser.joinDate}</p>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-500">Last Active</label>
                    <p className="text-gray-900">{selectedUser.lastActive}</p>
                  </div>
                </div>

                {selectedUser.revenue && (
                  <div>
                    <label className="text-sm font-medium text-gray-500">Revenue Generated</label>
                    <p className="text-2xl font-bold text-green-600">R{selectedUser.revenue.toLocaleString()}</p>
                  </div>
                )}

                <div className="flex space-x-3">
                  <button className="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                    Verify User
                  </button>
                  <button className="flex-1 bg-yellow-600 text-white py-2 rounded-lg hover:bg-yellow-700">
                    Suspend
                  </button>
                  <button className="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">
                    Ban User
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

export default AdminDashboard;
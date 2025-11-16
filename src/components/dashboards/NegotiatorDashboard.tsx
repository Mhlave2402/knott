import React, { useState } from 'react';
import { Users, Calendar, DollarSign, BookOpen, Clock, Star, Award, TrendingUp, Phone, Mail, MessageCircle, MapPin, CheckCircle, AlertCircle, Plus, Search, Filter, Download, FileText, Heart, Crown, Shield, Globe, Target, BarChart3, PieChart, Calendar as CalendarIcon, User, Settings, Bell, Eye, CreditCard as Edit, X, ChevronRight, Handshake, Home, Gift } from 'lucide-react';

interface NegotiatorDashboardProps {
  userName: string;
}

interface Consultation {
  id: string;
  familyName: string;
  type: 'lobola' | 'ceremony' | 'guidance' | 'mediation';
  status: 'scheduled' | 'in-progress' | 'completed' | 'cancelled';
  date: string;
  time: string;
  location: string;
  fee: number;
  paid: boolean;
  notes?: string;
  culturalBackground: string;
  priority: 'high' | 'medium' | 'low';
  contactPerson: string;
  phone: string;
  email: string;
}

interface CulturalResource {
  id: string;
  title: string;
  category: 'protocol' | 'ceremony' | 'negotiation' | 'cultural';
  description: string;
  content: string;
  lastUpdated: string;
  views: number;
}

interface Client {
  id: string;
  name: string;
  family: string;
  culturalBackground: string;
  totalSessions: number;
  totalPaid: number;
  status: 'active' | 'completed' | 'inactive';
  lastSession: string;
  rating: number;
  testimonial?: string;
}

const NegotiatorDashboard: React.FC<NegotiatorDashboardProps> = ({ userName }) => {
  const [selectedTab, setSelectedTab] = useState('overview');
  const [showConsultationModal, setShowConsultationModal] = useState(false);
  const [showResourceModal, setShowResourceModal] = useState(false);
  const [showProfileSetup, setShowProfileSetup] = useState(false);
  const [selectedConsultation, setSelectedConsultation] = useState<Consultation | null>(null);
  const [searchTerm, setSearchTerm] = useState('');
  const [filterStatus, setFilterStatus] = useState('all');
  
  // Negotiator profile state
  const [negotiatorProfile, setNegotiatorProfile] = useState({
    culturalBackground: '',
    acceptedSurnames: [] as string[],
    specializations: [] as string[],
    isProfileComplete: false
  });

  const tabs = [
    { id: 'overview', label: 'Overview', icon: TrendingUp },
    { id: 'consultations', label: 'Consultations', icon: Calendar },
    { id: 'clients', label: 'Clients', icon: Users },
    { id: 'resources', label: 'Cultural Resources', icon: BookOpen },
    { id: 'earnings', label: 'Earnings', icon: DollarSign },
    { id: 'analytics', label: 'Analytics', icon: BarChart3 },
    { id: 'profile', label: 'Profile', icon: User },
    { id: 'settings', label: 'Settings', icon: Settings }
  ];

  const stats = [
    { label: 'Active Consultations', value: '12', icon: Users, color: 'purple', trend: '+15%' },
    { label: 'Monthly Earnings', value: 'R18,400', icon: DollarSign, color: 'green', trend: '+22%' },
    { label: 'Success Rate', value: '96%', icon: Award, color: 'blue', trend: '+2%' },
    { label: 'Client Satisfaction', value: '4.9', icon: Star, color: 'yellow', trend: '+0.1' },
    { label: 'Total Families Helped', value: '147', icon: Heart, color: 'pink', trend: '+8' },
    { label: 'Cultural Ceremonies', value: '89', icon: Crown, color: 'indigo', trend: '+12' }
  ];

  const consultations: Consultation[] = [
    {
      id: '1',
      familyName: 'Mthembu Family',
      type: 'lobola',
      status: 'scheduled',
      date: '2025-02-15',
      time: '14:00',
      location: 'Johannesburg, Gauteng',
      fee: 1200,
      paid: false,
      culturalBackground: 'Zulu',
      priority: 'high',
      contactPerson: 'Sipho Mthembu',
      phone: '+27 82 123 4567',
      email: 'sipho@email.com',
      notes: 'First-time lobola negotiation, need cultural guidance'
    },
    {
      id: '2',
      familyName: 'Khumalo Family',
      type: 'ceremony',
      status: 'in-progress',
      date: '2025-02-18',
      time: '10:00',
      location: 'Durban, KwaZulu-Natal',
      fee: 800,
      paid: true,
      culturalBackground: 'Zulu',
      priority: 'medium',
      contactPerson: 'Nomsa Khumalo',
      phone: '+27 83 234 5678',
      email: 'nomsa@email.com',
      notes: 'Traditional wedding ceremony planning'
    },
    {
      id: '3',
      familyName: 'Mokone Family',
      type: 'guidance',
      status: 'completed',
      date: '2025-02-10',
      time: '16:00',
      location: 'Pretoria, Gauteng',
      fee: 600,
      paid: true,
      culturalBackground: 'Sotho',
      priority: 'low',
      contactPerson: 'Thabo Mokone',
      phone: '+27 84 345 6789',
      email: 'thabo@email.com',
      notes: 'Cultural education for mixed heritage couple'
    }
  ];

  const clients: Client[] = [
    {
      id: '1',
      name: 'Sipho Mthembu',
      family: 'Mthembu Family',
      culturalBackground: 'Zulu',
      totalSessions: 3,
      totalPaid: 2400,
      status: 'active',
      lastSession: '2025-01-15',
      rating: 5.0,
      testimonial: 'Exceptional guidance through our traditional ceremony'
    },
    {
      id: '2',
      name: 'Nomsa Khumalo',
      family: 'Khumalo Family',
      culturalBackground: 'Zulu',
      totalSessions: 5,
      totalPaid: 4000,
      status: 'completed',
      lastSession: '2024-12-20',
      rating: 4.8,
      testimonial: 'Professional and respectful approach to our traditions'
    }
  ];

  const culturalResources: CulturalResource[] = [
    {
      id: '1',
      title: 'Zulu Lobola Negotiation Protocols',
      category: 'negotiation',
      description: 'Complete guide to traditional Zulu lobola negotiations',
      content: 'Detailed protocols and procedures...',
      lastUpdated: '2025-01-20',
      views: 234
    },
    {
      id: '2',
      title: 'Sotho Wedding Ceremony Traditions',
      category: 'ceremony',
      description: 'Traditional Sotho wedding ceremony procedures',
      content: 'Step-by-step ceremony guide...',
      lastUpdated: '2025-01-18',
      views: 189
    },
    {
      id: '3',
      title: 'Cross-Cultural Marriage Guidance',
      category: 'cultural',
      description: 'Guidelines for mixed heritage marriages',
      content: 'Cultural integration strategies...',
      lastUpdated: '2025-01-15',
      views: 156
    }
  ];

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'scheduled': return 'bg-blue-100 text-blue-700';
      case 'in-progress': return 'bg-yellow-100 text-yellow-700';
      case 'completed': return 'bg-green-100 text-green-700';
      case 'cancelled': return 'bg-red-100 text-red-700';
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

  const getTypeIcon = (type: string) => {
    switch (type) {
      case 'lobola': return Handshake;
      case 'ceremony': return Crown;
      case 'guidance': return BookOpen;
      case 'mediation': return Users;
      default: return Calendar;
    }
  };

  const filteredConsultations = consultations.filter(consultation => {
    const matchesSearch = consultation.familyName.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         consultation.contactPerson.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesFilter = filterStatus === 'all' || consultation.status === filterStatus;
    return matchesSearch && matchesFilter;
  });

  return (
    <div className="p-6">
      {/* Header */}
      <div className="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-2xl p-6 text-white mb-8">
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold mb-2">Welcome back, {userName}! 🤝</h1>
            <p className="text-purple-100">Traditional Wedding Negotiator & Cultural Guide</p>
            <div className="flex items-center space-x-4 mt-3">
              <div className="flex items-center space-x-2">
                <Award className="h-4 w-4" />
                <span className="text-sm">15+ Years Experience</span>
              </div>
              <div className="flex items-center space-x-2">
                <Shield className="h-4 w-4" />
                <span className="text-sm">Certified Cultural Mediator</span>
              </div>
              <div className="flex items-center space-x-2">
                <Globe className="h-4 w-4" />
                <span className="text-sm">Multi-Cultural Specialist</span>
              </div>
            </div>
          </div>
          <div className="text-center">
            <div className="text-3xl font-bold">96%</div>
            <div className="text-sm text-purple-100">Success Rate</div>
            <div className="mt-2">
              <div className="flex items-center space-x-1">
                <Star className="h-4 w-4 text-yellow-400 fill-current" />
                <span className="text-sm">4.9 Rating</span>
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
                    ? 'bg-purple-500 text-white shadow-md'
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
          {/* Profile Completion Alert */}
          {!negotiatorProfile.isProfileComplete && (
            <div className="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
              <div className="flex items-center space-x-3">
                <AlertCircle className="h-6 w-6 text-yellow-600" />
                <div className="flex-1">
                  <h3 className="font-semibold text-yellow-800">Complete Your Cultural Profile</h3>
                  <p className="text-yellow-700 text-sm mt-1">
                    Set your cultural background and accepted family surnames to receive matching consultation requests.
                  </p>
                </div>
                <button 
                  onClick={() => setShowProfileSetup(true)}
                  className="bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-yellow-700 transition-colors"
                >
                  Complete Profile
                </button>
              </div>
            </div>
          )}

          {/* Stats Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {stats.map((stat) => {
              const Icon = stat.icon;
              return (
                <div key={stat.label} className="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                  <div className="flex items-center justify-between mb-4">
                    <div className={`w-12 h-12 bg-${stat.color}-100 rounded-lg flex items-center justify-center`}>
                      <Icon className={`h-6 w-6 text-${stat.color}-600`} />
                    </div>
                    <div className="text-right">
                      <div className="text-2xl font-bold text-gray-900">{stat.value}</div>
                      <div className="text-xs text-green-600 font-medium">{stat.trend}</div>
                    </div>
                  </div>
                  <div className="text-sm text-gray-600">{stat.label}</div>
                </div>
              );
            })}
          </div>

          {/* Quick Actions */}
          <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button 
              onClick={() => setShowConsultationModal(true)}
              className="bg-gradient-to-r from-purple-500 to-indigo-600 text-white p-4 rounded-xl font-medium hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 flex items-center space-x-2"
            >
              <Plus className="h-5 w-5" />
              <span>Add Consultation</span>
            </button>
            <button className="bg-white border border-gray-200 text-gray-700 p-4 rounded-xl font-medium hover:bg-gray-50 transition-colors flex items-center space-x-2">
              <Calendar className="h-5 w-5" />
              <span>View Calendar</span>
            </button>
            <button className="bg-white border border-gray-200 text-gray-700 p-4 rounded-xl font-medium hover:bg-gray-50 transition-colors flex items-center space-x-2">
              <FileText className="h-5 w-5" />
              <span>Generate Report</span>
            </button>
            <button 
              onClick={() => setShowResourceModal(true)}
              className="bg-white border border-gray-200 text-gray-700 p-4 rounded-xl font-medium hover:bg-gray-50 transition-colors flex items-center space-x-2"
            >
              <BookOpen className="h-5 w-5" />
              <span>Add Resource</span>
            </button>
          </div>

          {/* Recent Activity */}
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-lg font-semibold text-gray-900">Upcoming Consultations</h3>
                <button className="text-purple-600 hover:text-purple-700 text-sm font-medium">View All</button>
              </div>
              <div className="space-y-3">
                {consultations.filter(c => c.status === 'scheduled').slice(0, 3).map((consultation) => {
                  const TypeIcon = getTypeIcon(consultation.type);
                  return (
                    <div key={consultation.id} className="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                      <div className="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <TypeIcon className="h-5 w-5 text-purple-600" />
                      </div>
                      <div className="flex-1">
                        <div className="font-medium text-gray-900">{consultation.familyName}</div>
                        <div className="text-sm text-gray-500">{consultation.date} at {consultation.time}</div>
                      </div>
                      <div className="text-right">
                        <div className="font-medium text-gray-700">R{consultation.fee}</div>
                        <span className={`px-2 py-1 rounded-full text-xs font-medium ${getPriorityColor(consultation.priority)}`}>
                          {consultation.priority}
                        </span>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-lg font-semibold text-gray-900">Recent Client Feedback</h3>
                <button className="text-purple-600 hover:text-purple-700 text-sm font-medium">View All</button>
              </div>
              <div className="space-y-4">
                {clients.slice(0, 2).map((client) => (
                  <div key={client.id} className="p-4 bg-gray-50 rounded-lg">
                    <div className="flex items-center justify-between mb-2">
                      <div className="font-medium text-gray-900">{client.name}</div>
                      <div className="flex items-center space-x-1">
                        <Star className="h-4 w-4 text-yellow-500 fill-current" />
                        <span className="text-sm text-gray-600">{client.rating}</span>
                      </div>
                    </div>
                    <p className="text-sm text-gray-600 italic">"{client.testimonial}"</p>
                    <div className="text-xs text-gray-500 mt-2">{client.culturalBackground} • {client.totalSessions} sessions</div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'consultations' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-xl font-semibold text-gray-900">Consultation Management</h3>
              <p className="text-gray-600">Manage your traditional wedding consultations and negotiations</p>
            </div>
            <button 
              onClick={() => setShowConsultationModal(true)}
              className="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:from-purple-600 hover:to-indigo-700 transition-all duration-200"
            >
              <Plus className="h-4 w-4 inline mr-2" />
              New Consultation
            </button>
          </div>

          {/* Search and Filters */}
          <div className="bg-white rounded-xl p-6 shadow-sm">
            <div className="flex flex-col md:flex-row gap-4">
              <div className="relative flex-1">
                <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                <input
                  type="text"
                  placeholder="Search consultations..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                />
              </div>
              <select
                value={filterStatus}
                onChange={(e) => setFilterStatus(e.target.value)}
                className="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
              >
                <option value="all">All Status</option>
                <option value="scheduled">Scheduled</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
          </div>

          {/* Consultations List */}
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {filteredConsultations.map((consultation) => {
              const TypeIcon = getTypeIcon(consultation.type);
              return (
                <div key={consultation.id} className="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                  <div className="flex items-center justify-between mb-4">
                    <div className="flex items-center space-x-3">
                      <div className="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <TypeIcon className="h-6 w-6 text-purple-600" />
                      </div>
                      <div>
                        <h4 className="font-semibold text-gray-900">{consultation.familyName}</h4>
                        <p className="text-sm text-gray-600 capitalize">{consultation.type} • {consultation.culturalBackground}</p>
                      </div>
                    </div>
                    <div className="flex items-center space-x-2">
                      <span className={`px-3 py-1 rounded-full text-xs font-medium ${getStatusColor(consultation.status)}`}>
                        {consultation.status}
                      </span>
                      <span className={`px-2 py-1 rounded-full text-xs font-medium ${getPriorityColor(consultation.priority)}`}>
                        {consultation.priority}
                      </span>
                    </div>
                  </div>

                  <div className="space-y-3 mb-4">
                    <div className="flex items-center justify-between">
                      <div className="flex items-center space-x-2 text-sm text-gray-600">
                        <Calendar className="h-4 w-4" />
                        <span>{consultation.date} at {consultation.time}</span>
                      </div>
                      <div className="font-medium text-gray-900">R{consultation.fee}</div>
                    </div>
                    <div className="flex items-center space-x-2 text-sm text-gray-600">
                      <MapPin className="h-4 w-4" />
                      <span>{consultation.location}</span>
                    </div>
                    <div className="flex items-center space-x-2 text-sm text-gray-600">
                      <User className="h-4 w-4" />
                      <span>{consultation.contactPerson}</span>
                    </div>
                    {consultation.notes && (
                      <div className="text-sm text-gray-600 bg-gray-50 p-2 rounded-lg">
                        <span className="font-medium">Notes:</span> {consultation.notes}
                      </div>
                    )}
                  </div>

                  <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-2">
                      {consultation.paid ? (
                        <span className="flex items-center space-x-1 text-green-600 text-sm">
                          <CheckCircle className="h-4 w-4" />
                          <span>Paid</span>
                        </span>
                      ) : (
                        <span className="flex items-center space-x-1 text-red-600 text-sm">
                          <AlertCircle className="h-4 w-4" />
                          <span>Payment Pending</span>
                        </span>
                      )}
                    </div>
                    <div className="flex space-x-2">
                      <button 
                        onClick={() => {
                          setSelectedConsultation(consultation);
                          setShowConsultationModal(true);
                        }}
                        className="p-2 text-gray-400 hover:text-purple-600 transition-colors"
                      >
                        <Eye className="h-4 w-4" />
                      </button>
                      <button className="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                        <Phone className="h-4 w-4" />
                      </button>
                      <button className="p-2 text-gray-400 hover:text-green-600 transition-colors">
                        <MessageCircle className="h-4 w-4" />
                      </button>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      )}

      {selectedTab === 'clients' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-xl font-semibold text-gray-900">Client Management</h3>
              <p className="text-gray-600">Track your client relationships and session history</p>
            </div>
            <div className="flex space-x-3">
              <button className="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                <Download className="h-4 w-4 inline mr-2" />
                Export
              </button>
            </div>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            {clients.map((client) => (
              <div key={client.id} className="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div className="flex items-center justify-between mb-4">
                  <div>
                    <h4 className="font-semibold text-gray-900">{client.name}</h4>
                    <p className="text-sm text-gray-600">{client.family}</p>
                  </div>
                  <span className={`px-3 py-1 rounded-full text-xs font-medium ${
                    client.status === 'active' ? 'bg-green-100 text-green-700' :
                    client.status === 'completed' ? 'bg-blue-100 text-blue-700' :
                    'bg-gray-100 text-gray-700'
                  }`}>
                    {client.status}
                  </span>
                </div>

                <div className="space-y-3 mb-4">
                  <div className="flex justify-between items-center">
                    <span className="text-sm text-gray-600">Cultural Background</span>
                    <span className="text-sm font-medium text-gray-900">{client.culturalBackground}</span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-sm text-gray-600">Total Sessions</span>
                    <span className="text-sm font-medium text-gray-900">{client.totalSessions}</span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-sm text-gray-600">Total Paid</span>
                    <span className="text-sm font-medium text-green-600">R{client.totalPaid.toLocaleString()}</span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-sm text-gray-600">Last Session</span>
                    <span className="text-sm font-medium text-gray-900">{client.lastSession}</span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-sm text-gray-600">Rating</span>
                    <div className="flex items-center space-x-1">
                      <Star className="h-4 w-4 text-yellow-500 fill-current" />
                      <span className="text-sm font-medium text-gray-900">{client.rating}</span>
                    </div>
                  </div>
                </div>

                {client.testimonial && (
                  <div className="p-3 bg-gray-50 rounded-lg mb-4">
                    <p className="text-sm text-gray-600 italic">"{client.testimonial}"</p>
                  </div>
                )}

                <div className="flex space-x-2">
                  <button className="flex-1 bg-purple-500 text-white py-2 rounded-lg text-sm font-medium hover:bg-purple-600 transition-colors">
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

      {selectedTab === 'resources' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-xl font-semibold text-gray-900">Cultural Resources</h3>
              <p className="text-gray-600">Manage your knowledge base and cultural protocols</p>
            </div>
            <button 
              onClick={() => setShowResourceModal(true)}
              className="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:from-purple-600 hover:to-indigo-700 transition-all duration-200"
            >
              <Plus className="h-4 w-4 inline mr-2" />
              Add Resource
            </button>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            {culturalResources.map((resource) => (
              <div key={resource.id} className="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div className="flex items-center justify-between mb-4">
                  <span className={`px-3 py-1 rounded-full text-xs font-medium ${
                    resource.category === 'protocol' ? 'bg-blue-100 text-blue-700' :
                    resource.category === 'ceremony' ? 'bg-purple-100 text-purple-700' :
                    resource.category === 'negotiation' ? 'bg-green-100 text-green-700' :
                    'bg-yellow-100 text-yellow-700'
                  }`}>
                    {resource.category}
                  </span>
                  <div className="flex items-center space-x-1 text-sm text-gray-500">
                    <Eye className="h-4 w-4" />
                    <span>{resource.views}</span>
                  </div>
                </div>

                <h4 className="font-semibold text-gray-900 mb-2">{resource.title}</h4>
                <p className="text-sm text-gray-600 mb-4">{resource.description}</p>

                <div className="flex items-center justify-between text-xs text-gray-500 mb-4">
                  <span>Updated: {resource.lastUpdated}</span>
                </div>

                <div className="flex space-x-2">
                  <button className="flex-1 bg-purple-500 text-white py-2 rounded-lg text-sm font-medium hover:bg-purple-600 transition-colors">
                    View Resource
                  </button>
                  <button className="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <Edit className="h-4 w-4" />
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      )}

      {selectedTab === 'earnings' && (
        <div className="space-y-6">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-xl font-semibold text-gray-900">Earnings Overview</h3>
              <p className="text-gray-600">Track your consultation fees and payments</p>
            </div>
            <div className="flex space-x-3">
              <button className="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                <Download className="h-4 w-4 inline mr-2" />
                Export Report
              </button>
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3 mb-4">
                <div className="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                  <DollarSign className="h-5 w-5 text-green-600" />
                </div>
                <div>
                  <h4 className="font-semibold text-gray-900">Monthly Earnings</h4>
                  <p className="text-sm text-gray-600">February 2025</p>
                </div>
              </div>
              <div className="text-2xl font-bold text-gray-900">R18,400</div>
              <div className="text-sm text-green-600 font-medium">+22% from last month</div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3 mb-4">
                <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                  <Calendar className="h-5 w-5 text-blue-600" />
                </div>
                <div>
                  <h4 className="font-semibold text-gray-900">Pending Payments</h4>
                  <p className="text-sm text-gray-600">Outstanding fees</p>
                </div>
              </div>
              <div className="text-2xl font-bold text-gray-900">R3,600</div>
              <div className="text-sm text-red-600 font-medium">3 consultations</div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <div className="flex items-center space-x-3 mb-4">
                <div className="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                  <TrendingUp className="h-5 w-5 text-purple-600" />
                </div>
                <div>
                  <h4 className="font-semibold text-gray-900">Average Fee</h4>
                  <p className="text-sm text-gray-600">Per consultation</p>
                </div>
              </div>
              <div className="text-2xl font-bold text-gray-900">R867</div>
              <div className="text-sm text-green-600 font-medium">+5% increase</div>
            </div>
          </div>

          <div className="bg-white rounded-xl p-6 shadow-sm">
            <h4 className="font-semibold text-gray-900 mb-4">Recent Transactions</h4>
            <div className="space-y-3">
              {consultations.filter(c => c.paid).map((consultation) => (
                <div key={consultation.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                  <div>
                    <div className="font-medium text-gray-900">{consultation.familyName}</div>
                    <div className="text-sm text-gray-500">{consultation.date} • {consultation.type}</div>
                  </div>
                  <div className="text-right">
                    <div className="font-medium text-green-600">+R{consultation.fee}</div>
                    <div className="text-xs text-gray-500">Paid</div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'analytics' && (
        <div className="space-y-6">
          <div>
            <h3 className="text-xl font-semibold text-gray-900">Performance Analytics</h3>
            <p className="text-gray-600">Insights into your negotiation practice</p>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Consultation Types</h4>
              <div className="space-y-3">
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">Lobola Negotiations</span>
                  <span className="font-medium">45%</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div className="bg-purple-500 h-2 rounded-full" style={{ width: '45%' }}></div>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">Traditional Ceremonies</span>
                  <span className="font-medium">30%</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div className="bg-blue-500 h-2 rounded-full" style={{ width: '30%' }}></div>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">Cultural Guidance</span>
                  <span className="font-medium">25%</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div className="bg-green-500 h-2 rounded-full" style={{ width: '25%' }}></div>
                </div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Cultural Backgrounds</h4>
              <div className="space-y-3">
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">Zulu</span>
                  <span className="font-medium">60%</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div className="bg-indigo-500 h-2 rounded-full" style={{ width: '60%' }}></div>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">Sotho</span>
                  <span className="font-medium">25%</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div className="bg-pink-500 h-2 rounded-full" style={{ width: '25%' }}></div>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">Xhosa</span>
                  <span className="font-medium">15%</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div className="bg-yellow-500 h-2 rounded-full" style={{ width: '15%' }}></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'profile' && (
        <div className="space-y-6">
          <div>
            <h3 className="text-xl font-semibold text-gray-900">Professional Profile</h3>
            <p className="text-gray-600">Manage your negotiator profile and credentials</p>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Profile Information</h4>
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                  <input type="text" value={userName} className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Specializations</label>
                  <input type="text" value="Zulu Traditions, Lobola Negotiations, Cultural Guidance" className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Years of Experience</label>
                  <input type="number" value="15" className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Hourly Rate</label>
                  <input type="number" value="800" className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" />
                </div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Credentials & Certifications</h4>
              <div className="space-y-3">
                <div className="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                  <Shield className="h-5 w-5 text-green-600" />
                  <div>
                    <div className="font-medium text-green-900">Certified Cultural Mediator</div>
                    <div className="text-sm text-green-700">Valid until 2026</div>
                  </div>
                </div>
                <div className="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                  <Award className="h-5 w-5 text-blue-600" />
                  <div>
                    <div className="font-medium text-blue-900">Traditional Marriage Counselor</div>
                    <div className="text-sm text-blue-700">Certified 2020</div>
                  </div>
                </div>
                <div className="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg">
                  <BookOpen className="h-5 w-5 text-purple-600" />
                  <div>
                    <div className="font-medium text-purple-900">Cultural Heritage Specialist</div>
                    <div className="text-sm text-purple-700">Advanced Certification</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {selectedTab === 'settings' && (
        <div className="space-y-6">
          <div>
            <h3 className="text-xl font-semibold text-gray-900">Account Settings</h3>
            <p className="text-gray-600">Manage your account preferences and notifications</p>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Notification Preferences</h4>
              <div className="space-y-4">
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-700">New Consultation Requests</span>
                  <button className="w-12 h-6 bg-purple-500 rounded-full relative">
                    <div className="w-5 h-5 bg-white rounded-full absolute right-0.5 top-0.5"></div>
                  </button>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-700">Payment Reminders</span>
                  <button className="w-12 h-6 bg-purple-500 rounded-full relative">
                    <div className="w-5 h-5 bg-white rounded-full absolute right-0.5 top-0.5"></div>
                  </button>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-700">Client Feedback</span>
                  <button className="w-12 h-6 bg-gray-300 rounded-full relative">
                    <div className="w-5 h-5 bg-white rounded-full absolute left-0.5 top-0.5"></div>
                  </button>
                </div>
              </div>
            </div>

            <div className="bg-white rounded-xl p-6 shadow-sm">
              <h4 className="font-semibold text-gray-900 mb-4">Availability Settings</h4>
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Working Hours</label>
                  <div className="grid grid-cols-2 gap-2">
                    <input type="time" value="09:00" className="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" />
                    <input type="time" value="17:00" className="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" />
                  </div>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Working Days</label>
                  <div className="flex flex-wrap gap-2">
                    {['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].map((day) => (
                      <button key={day} className="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                        {day}
                      </button>
                    ))}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Consultation Modal */}
      {showConsultationModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div className="p-6">
              <div className="flex justify-between items-center mb-6">
                <h3 className="text-xl font-bold text-gray-900">
                  {selectedConsultation ? 'Consultation Details' : 'New Consultation'}
                </h3>
                <button
                  onClick={() => {
                    setShowConsultationModal(false);
                    setSelectedConsultation(null);
                  }}
                  className="p-2 hover:bg-gray-100 rounded-full transition-colors"
                >
                  <X className="h-5 w-5 text-gray-500" />
                </button>
              </div>

              <div className="space-y-6">
                <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                  <div className="flex items-start space-x-3">
                    <BookOpen className="h-5 w-5 text-blue-600 mt-0.5" />
                    <div>
                      <h4 className="font-medium text-blue-900">Adding a New Consultation</h4>
                      <p className="text-blue-700 text-sm mt-1">
                        Use this form when families contact you directly or when scheduling follow-up sessions. 
                        The system will verify cultural and surname compatibility.
                      </p>
                    </div>
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Family Name</label>
                    <input
                      type="text"
                      defaultValue={selectedConsultation?.familyName || ''}
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                      placeholder="e.g., Mthembu Family"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
                    <input
                      type="text"
                      defaultValue={selectedConsultation?.contactPerson || ''}
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                      placeholder="Contact person name"
                    />
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Consultation Type</label>
                    <select
                      defaultValue={selectedConsultation?.type || 'lobola'}
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                    >
                      <option value="lobola">Lobola Negotiation</option>
                      <option value="ceremony">Traditional Ceremony</option>
                      <option value="guidance">Cultural Guidance</option>
                      <option value="mediation">Family Mediation</option>
                    </select>
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Cultural Background</label>
                    <select
                      defaultValue={selectedConsultation?.culturalBackground || 'Zulu'}
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                    >
                      <option value="Zulu">Zulu (Mthembu, Khumalo, Dlamini, Nkosi, Zulu)</option>
                      <option value="Sotho">Sotho (Mokone, Molefe, Mokoena, Mthembu, Tau)</option>
                      <option value="Xhosa">Xhosa (Mandela, Sisulu, Biko, Mthembu, Gqabi)</option>
                      <option value="Tswana">Tswana (Mogale, Mmusi, Kgosana, Molefe, Seroke)</option>
                    </select>
                  </div>
                </div>
                
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Family Surname</label>
                  <input
                    type="text"
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                    placeholder="Enter the family surname"
                  />
                  <p className="text-xs text-gray-500 mt-1">
                    System will verify surname compatibility with your cultural specialization
                  </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input
                      type="date"
                      defaultValue={selectedConsultation?.date || ''}
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Time</label>
                    <input
                      type="time"
                      defaultValue={selectedConsultation?.time || ''}
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Fee (R)</label>
                    <input
                      type="number"
                      defaultValue={selectedConsultation?.fee || 800}
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                    />
                  </div>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Location</label>
                  <input
                    type="text"
                    defaultValue={selectedConsultation?.location || ''}
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                    placeholder="Meeting location"
                  />
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                  <textarea
                    defaultValue={selectedConsultation?.notes || ''}
                    rows={4}
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                    placeholder="Additional notes about the consultation..."
                  />
                </div>

                <div className="flex space-x-3">
                  <button
                    onClick={() => {
                      setShowConsultationModal(false);
                      setSelectedConsultation(null);
                    }}
                    className="flex-1 border border-gray-300 text-gray-700 py-3 rounded-xl font-medium hover:bg-gray-50 transition-colors"
                  >
                    Cancel
                  </button>
                  <button className="flex-1 bg-gradient-to-r from-purple-500 to-indigo-600 text-white py-3 rounded-xl font-medium hover:from-purple-600 hover:to-indigo-700 transition-all duration-200">
                    {selectedConsultation ? 'Update Consultation' : 'Schedule Consultation'}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Profile Setup Modal */}
      {showProfileSetup && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div className="p-6">
              <div className="flex justify-between items-center mb-6">
                <h3 className="text-xl font-bold text-gray-900">Complete Your Cultural Profile</h3>
                <button
                  onClick={() => setShowProfileSetup(false)}
                  className="p-2 hover:bg-gray-100 rounded-full transition-colors"
                >
                  <X className="h-5 w-5 text-gray-500" />
                </button>
              </div>

              <div className="space-y-6">
                <div className="bg-purple-50 border border-purple-200 rounded-lg p-4">
                  <div className="flex items-start space-x-3">
                    <Shield className="h-5 w-5 text-purple-600 mt-0.5" />
                    <div>
                      <h4 className="font-medium text-purple-900">Cultural Authenticity</h4>
                      <p className="text-purple-700 text-sm mt-1">
                        To maintain cultural authenticity, you can only assist families from your cultural background 
                        with matching or compatible surnames. This ensures proper traditional protocols are followed.
                      </p>
                    </div>
                  </div>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Your Cultural Background</label>
                  <select
                    value={negotiatorProfile.culturalBackground}
                    onChange={(e) => setNegotiatorProfile({...negotiatorProfile, culturalBackground: e.target.value})}
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                  >
                    <option value="">Select your cultural background</option>
                    <option value="Zulu">Zulu</option>
                    <option value="Sotho">Sotho</option>
                    <option value="Xhosa">Xhosa</option>
                    <option value="Tswana">Tswana</option>
                    <option value="Ndebele">Ndebele</option>
                    <option value="Venda">Venda</option>
                    <option value="Tsonga">Tsonga</option>
                  </select>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Accepted Family Surnames</label>
                  <textarea
                    rows={4}
                    placeholder="Enter surnames you can assist with, separated by commas (e.g., Mthembu, Khumalo, Dlamini, Nkosi)"
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"
                  />
                  <p className="text-xs text-gray-500 mt-1">
                    Only families with these surnames will be matched with you for consultations
                  </p>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Your Specializations</label>
                  <div className="grid grid-cols-2 gap-3">
                    {[
                      'Lobola Negotiations',
                      'Traditional Ceremonies', 
                      'Cultural Guidance',
                      'Family Mediation',
                      'Wedding Protocols',
                      'Cross-Cultural Marriages'
                    ].map((spec) => (
                      <label key={spec} className="flex items-center space-x-2">
                        <input type="checkbox" className="rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                        <span className="text-sm text-gray-700">{spec}</span>
                      </label>
                    ))}
                  </div>
                </div>

                <div className="bg-gray-50 rounded-lg p-4">
                  <h4 className="font-medium text-gray-900 mb-2">How Cultural Matching Works:</h4>
                  <ul className="text-sm text-gray-600 space-y-1">
                    <li>• Families will only see negotiators from their cultural background</li>
                    <li>• Surname compatibility is verified before booking</li>
                    <li>• This ensures authentic traditional guidance</li>
                    <li>• Maintains cultural protocols and respect</li>
                  </ul>
                </div>

                <div className="flex space-x-3">
                  <button
                    onClick={() => setShowProfileSetup(false)}
                    className="flex-1 border border-gray-300 text-gray-700 py-3 rounded-xl font-medium hover:bg-gray-50 transition-colors"
                  >
                    Cancel
                  </button>
                  <button 
                    onClick={() => {
                      setNegotiatorProfile({...negotiatorProfile, isProfileComplete: true});
                      setShowProfileSetup(false);
                    }}
                    className="flex-1 bg-gradient-to-r from-purple-500 to-indigo-600 text-white py-3 rounded-xl font-medium hover:from-purple-600 hover:to-indigo-700 transition-all duration-200"
                  >
                    Complete Profile
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

export default NegotiatorDashboard;
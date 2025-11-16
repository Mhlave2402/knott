import React, { useState } from 'react';
import { X, Mail, Lock, User, Briefcase, MapPin, Users, ShoppingBag, Shield } from 'lucide-react';
import { UserRole } from '../types';

interface AuthModalProps {
  isOpen: boolean;
  onClose: () => void;
  onAuth: (user: { name: string; email: string; role: UserRole }) => void;
}

const roleOptions = [
  { 
    value: 'couple' as UserRole, 
    label: 'Couple', 
    icon: User, 
    description: 'Planning your special day',
    color: 'from-pink-500 to-rose-500'
  },
  { 
    value: 'pro' as UserRole, 
    label: 'Pro', 
    icon: Briefcase, 
    description: 'Wedding service provider',
    color: 'from-blue-500 to-indigo-500'
  },
  { 
    value: 'venue' as UserRole, 
    label: 'Venue', 
    icon: MapPin, 
    description: 'Wedding venue owner',
    color: 'from-green-500 to-emerald-500'
  },
  { 
    value: 'negotiator' as UserRole, 
    label: 'Negotiator', 
    icon: Users, 
    description: 'Traditional ceremony mediator',
    color: 'from-purple-500 to-violet-500'
  },
  { 
    value: 'guest' as UserRole, 
    label: 'Guest', 
    icon: Users, 
    description: 'Wedding attendee',
    color: 'from-yellow-500 to-orange-500'
  },
  { 
    value: 'seller' as UserRole, 
    label: 'Seller', 
    icon: ShoppingBag, 
    description: 'Selling pre-loved items',
    color: 'from-teal-500 to-cyan-500'
  },
  { 
    value: 'admin' as UserRole, 
    label: 'Admin', 
    icon: Shield, 
    description: 'Platform administrator',
    color: 'from-indigo-500 to-purple-500'
  },
];

const AuthModal: React.FC<AuthModalProps> = ({ isOpen, onClose, onAuth }) => {
  const [isLogin, setIsLogin] = useState(true);
  const [selectedRole, setSelectedRole] = useState<UserRole>('couple');
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onAuth({
      name: formData.name || 'Demo User',
      email: formData.email,
      role: selectedRole,
    });
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <div className="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div className="p-6">
          {/* Header */}
          <div className="flex justify-between items-center mb-6">
            <h2 className="text-2xl font-bold text-gray-800">
              {isLogin ? 'Welcome Back' : 'Join Knott'}
            </h2>
            <button
              onClick={onClose}
              className="p-2 hover:bg-gray-100 rounded-full transition-colors"
            >
              <X className="h-5 w-5 text-gray-500" />
            </button>
          </div>

          {/* Role Selection */}
          {!isLogin && (
            <div className="mb-6">
              <label className="block text-sm font-medium text-gray-700 mb-3">
                I am a...
              </label>
              <div className="grid grid-cols-2 gap-3">
                {roleOptions.map((role) => {
                  const Icon = role.icon;
                  return (
                    <button
                      key={role.value}
                      onClick={() => setSelectedRole(role.value)}
                      className={`p-3 rounded-xl border-2 transition-all duration-200 text-left ${
                        selectedRole === role.value
                          ? `border-pink-300 bg-gradient-to-r ${role.color} text-white shadow-lg transform scale-105`
                          : 'border-gray-200 hover:border-gray-300 bg-white text-gray-700'
                      }`}
                    >
                      <Icon className="h-5 w-5 mb-1" />
                      <div className="font-medium text-sm">{role.label}</div>
                      <div className="text-xs opacity-80">{role.description}</div>
                    </button>
                  );
                })}
              </div>
            </div>
          )}

          {/* Form */}
          <form onSubmit={handleSubmit} className="space-y-4">
            {!isLogin && (
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">
                  Full Name
                </label>
                <div className="relative">
                  <User className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                  <input
                    type="text"
                    value={formData.name}
                    onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                    className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors"
                    placeholder="Enter your full name"
                  />
                </div>
              </div>
            )}

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Email Address
              </label>
              <div className="relative">
                <Mail className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                <input
                  type="email"
                  value={formData.email}
                  onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                  className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors"
                  placeholder="Enter your email"
                  required
                />
              </div>
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Password
              </label>
              <div className="relative">
                <Lock className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                <input
                  type="password"
                  value={formData.password}
                  onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                  className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors"
                  placeholder="Enter your password"
                  required
                />
              </div>
            </div>

            <button
              type="submit"
              className="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg"
            >
              {isLogin ? 'Sign In' : 'Create Account'}
            </button>
          </form>

          {/* Toggle */}
          <div className="text-center mt-6">
            <button
              onClick={() => setIsLogin(!isLogin)}
              className="text-pink-600 hover:text-pink-700 font-medium"
            >
              {isLogin ? "Don't have an account? Sign up" : "Already have an account? Sign in"}
            </button>
          </div>

          {/* Social Login */}
          <div className="mt-6 pt-6 border-t border-gray-200">
            <div className="grid grid-cols-2 gap-3">
              <button className="flex items-center justify-center space-x-2 border border-gray-300 rounded-xl py-3 hover:bg-gray-50 transition-colors">
                <div className="w-5 h-5 bg-red-500 rounded-full"></div>
                <span className="text-sm font-medium">Google</span>
              </button>
              <button className="flex items-center justify-center space-x-2 border border-gray-300 rounded-xl py-3 hover:bg-gray-50 transition-colors">
                <div className="w-5 h-5 bg-blue-600 rounded-full"></div>
                <span className="text-sm font-medium">Facebook</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default AuthModal;
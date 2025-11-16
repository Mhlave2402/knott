import React, { useState } from 'react';
import { Menu, X, Heart, Crown, Search, User, Bell } from 'lucide-react';
import { UserRole } from '../types';

interface NavbarProps {
  user?: { name: string; role: UserRole } | null;
  onLogin: () => void;
  onLogout: () => void;
  onNavigate?: (view: 'home' | 'pros' | 'venues' | 'negotiators' | 'sellers') => void;
}

const Navbar: React.FC<NavbarProps> = ({ user, onLogin, onLogout, onNavigate }) => {
  const [isOpen, setIsOpen] = useState(false);

  const navigationItems = [
    { label: 'Pros', view: 'pros' as const },
    { label: 'Venues', view: 'venues' as const },
    { label: 'Negotiators', view: 'negotiators' as const },
    { label: 'Sellers', view: 'sellers' as const },
  ];

  return (
    <nav className="bg-white shadow-md sticky top-0 z-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16">
          {/* Logo */}
          <div
            className="flex items-center space-x-2 cursor-pointer"
            onClick={() => onNavigate?.('home')}
          >
            <Heart className="h-8 w-8 text-pink-500" />
            <span className="text-2xl font-bold text-gray-800">Knott</span>
            <Crown className="h-5 w-5 text-yellow-500" />
          </div>

          {/* Desktop Navigation */}
          <div className="hidden md:flex items-center space-x-8">
            {navigationItems.map((item) => (
              <button
                key={item.label}
                onClick={() => onNavigate?.(item.view)}
                className="text-gray-600 hover:text-pink-600 transition-colors duration-200 font-medium"
              >
                {item.label}
              </button>
            ))}
          </div>

          {/* User Actions */}
          <div className="flex items-center space-x-4">
            {user ? (
              <div className="flex items-center space-x-3">
                <Search className="h-5 w-5 text-gray-500 cursor-pointer hover:text-pink-500 transition-colors" />
                <Bell className="h-5 w-5 text-gray-500 cursor-pointer hover:text-pink-500 transition-colors" />
                <div className="flex items-center space-x-2">
                  <div className="w-8 h-8 bg-gradient-to-r from-pink-400 to-purple-500 rounded-full flex items-center justify-center">
                    <User className="h-4 w-4 text-white" />
                  </div>
                  <span className="text-sm font-medium text-gray-700">{user.name}</span>
                </div>
                <button
                  onClick={onLogout}
                  className="text-sm text-gray-500 hover:text-pink-600 transition-colors"
                >
                  Logout
                </button>
              </div>
            ) : (
              <button
                onClick={onLogin}
                className="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-2 rounded-full font-medium hover:from-pink-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105"
              >
                Sign In
              </button>
            )}

            {/* Mobile menu button */}
            <button
              onClick={() => setIsOpen(!isOpen)}
              className="md:hidden p-2 rounded-md text-gray-600 hover:text-pink-600 hover:bg-gray-100 transition-colors"
            >
              {isOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
            </button>
          </div>
        </div>

        {/* Mobile Navigation */}
        {isOpen && (
          <div className="md:hidden bg-white border-t border-gray-200 py-4 space-y-2">
            {navigationItems.map((item) => (
              <button
                key={item.label}
                onClick={() => {
                  onNavigate?.(item.view);
                  setIsOpen(false);
                }}
                className="block w-full text-left px-4 py-2 text-gray-600 hover:text-pink-600 hover:bg-gray-50 transition-colors rounded-md"
              >
                {item.label}
              </button>
            ))}
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;

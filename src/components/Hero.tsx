import React from 'react';
import { Heart, Sparkles, Users, Bot } from 'lucide-react';

interface HeroProps {
  onGetStarted: () => void;
}

const Hero: React.FC<HeroProps> = ({ onGetStarted }) => {
  return (
    <div className="relative bg-gradient-to-br from-pink-50 via-purple-50 to-blue-50 min-h-screen flex items-center">
      {/* Background Pattern */}
      <div className="absolute inset-0 opacity-10">
        <div className="absolute top-10 left-10 w-20 h-20 bg-pink-300 rounded-full animate-pulse"></div>
        <div className="absolute top-32 right-20 w-16 h-16 bg-purple-300 rounded-full animate-pulse animation-delay-1000"></div>
        <div className="absolute bottom-20 left-20 w-24 h-24 bg-blue-300 rounded-full animate-pulse animation-delay-2000"></div>
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          {/* Content */}
          <div className="space-y-8">
            <div className="space-y-4">
              <div className="flex items-center space-x-2">
                <Sparkles className="h-6 w-6 text-yellow-500" />
                <span className="text-pink-600 font-semibold">AI-Powered Wedding Planning</span>
              </div>
              <h1 className="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                Your Dream Wedding
                <span className="block text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600">
                  Made Simple
                </span>
              </h1>
              <p className="text-xl text-gray-600 leading-relaxed">
                Connect with the perfect pros, venues, manage your budget effortlessly, and honor your traditions with our culturally-aware platform that brings your vision to life.
              </p>
            </div>

            {/* Features */}
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-6">
              <div className="flex items-center space-x-3 bg-white/60 backdrop-blur-sm p-4 rounded-xl">
                <div className="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                  <Heart className="h-5 w-5 text-pink-600" />
                </div>
                <div>
                  <h3 className="font-semibold text-gray-800">AI Matching</h3>
                  <div className="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
  <Bot className="h-5 w-5 text-pink-600" />   {/* AI Matching */}
</div>
                </div>
              </div>
              <div className="flex items-center space-x-3 bg-white/60 backdrop-blur-sm p-4 rounded-xl">
                <div className="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                  <Users className="h-5 w-5 text-purple-600" />
                </div>
                <div>
                  <h3 className="font-semibold text-gray-800">Cultural</h3>
                  <p className="text-sm text-gray-600">Traditional ceremonies</p>
                </div>
              </div>
              <div className="flex items-center space-x-3 bg-white/60 backdrop-blur-sm p-4 rounded-xl">
                <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                  <Sparkles className="h-5 w-5 text-blue-600" />
                </div>
                <div>
                  <h3 className="font-semibold text-gray-800">Gift Well</h3>
                  <p className="text-sm text-gray-600">Digital registries</p>
                </div>
              </div>
            </div>

            {/* CTA Buttons */}
            <div className="flex flex-col sm:flex-row gap-4">
              <button
                onClick={onGetStarted}
                className="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-4 rounded-full font-semibold text-lg hover:from-pink-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl"
              >
                Start Planning Your Wedding
              </button>
              <button className="border-2 border-pink-300 text-pink-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-pink-50 transition-all duration-200">
                Join as Pro
              </button>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-3 gap-8 pt-8 border-t border-gray-200">
              <div className="text-center">
                <div className="text-3xl font-bold text-gray-900">5K+</div>
                <div className="text-sm text-gray-600">Happy Couples</div>
              </div>
              <div className="text-center">
                <div className="text-3xl font-bold text-gray-900">1.2K+</div>
                <div className="text-sm text-gray-600">Verified Pros</div>
              </div>
              <div className="text-center">
                <div className="text-3xl font-bold text-gray-900">500+</div>
                <div className="text-sm text-gray-600">Beautiful Venues</div>
              </div>
            </div>
          </div>

          {/* Hero Image */}
          <div className="relative">
            <div className="absolute inset-0 bg-gradient-to-r from-pink-200 to-purple-200 rounded-3xl transform rotate-3"></div>
            <div className="relative bg-white rounded-3xl shadow-2xl overflow-hidden transform -rotate-1 hover:rotate-0 transition-transform duration-500">
              <img
                src="https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=800"
                alt="Beautiful wedding couple"
                className="w-full h-96 object-cover"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
              <div className="absolute bottom-6 left-6 text-white">
                <p className="font-semibold">Your perfect day awaits</p>
                <p className="text-sm opacity-90">Let us make it extraordinary</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Hero;
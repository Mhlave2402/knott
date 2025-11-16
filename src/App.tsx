import React, { useState } from 'react';
import Navbar from './components/Navbar';
import Hero from './components/Hero';
import ProDirectory from './components/ProDirectory';
import VenueDirectory from './components/VenueDirectory';
import NegotiatorDirectory from './components/NegotiatorDirectory';
import SellerMarketplace from './components/SellerMarketplace';
import GiftWell from './components/GiftWell';
import CreateGiftRegistry from './components/CreateGiftRegistry';
import AIMatching from './components/AIMatching';
import Dashboard from './components/Dashboard';
import AuthModal from './components/AuthModal';
import Footer from './components/Footer';
import MapView from './components/MapView';
import { User, UserRole } from './types';

function App() {
  const [user, setUser] = useState<User | null>(null);
  const [showAuth, setShowAuth] = useState(false);
  const [showDashboard, setShowDashboard] = useState(false);
  const [currentView, setCurrentView] = useState<'home' | 'pros' | 'venues' | 'negotiators' | 'sellers'>('home');

  const handleLogin = () => {
    setShowAuth(true);
  };

  const handleAuth = (userData: { name: string; email: string; role: UserRole }) => {
    setUser({
      id: Math.random().toString(),
      name: userData.name,
      email: userData.email,
      role: userData.role,
      verified: true,
      premium: userData.role === 'pro' || userData.role === 'venue'
    });
    setShowAuth(false);
    setShowDashboard(true);
  };

  const handleLogout = () => {
    setUser(null);
    setShowDashboard(false);
  };

  const handleGetStarted = () => {
    if (user) {
      setShowDashboard(true);
    } else {
      setShowAuth(true);
    }
  };

  const handleNavigation = (view: 'home' | 'pros' | 'venues' | 'negotiators' | 'sellers') => {
    setCurrentView(view);
    setShowDashboard(false);
  };
  if (showDashboard && user) {
    return (
      <div className="min-h-screen">
        <Navbar user={user} onLogin={handleLogin} onLogout={handleLogout} onNavigate={handleNavigation} />
        <Dashboard userRole={user.role} userName={user.name} />
      </div>
    );
  }

  if (currentView !== 'home') {
    return (
      <div className="min-h-screen">
        <Navbar user={user} onLogin={handleLogin} onLogout={handleLogout} onNavigate={handleNavigation} />
        <MapView type={currentView} />
      </div>
    );
  }
  return (
    <div className="min-h-screen">
      <Navbar user={user} onLogin={handleLogin} onLogout={handleLogout} onNavigate={handleNavigation} />
      
      {/* Main Content */}
      <main>
        <Hero onGetStarted={handleGetStarted} />
        <ProDirectory />
        <VenueDirectory />
        <AIMatching />
        <NegotiatorDirectory />
        <GiftWell />
        <SellerMarketplace />
      </main>

      <Footer />

      {/* Auth Modal */}
      <AuthModal
        isOpen={showAuth}
        onClose={() => setShowAuth(false)}
        onAuth={handleAuth}
      />
    </div>
  );
}

export default App;
import React, { useState } from 'react';
import { UserRole } from '../types';
import CouplesDashboard from './dashboards/CouplesDashboard';
import ProDashboard from './dashboards/ProDashboard';
import VenueDashboard from './dashboards/VenueDashboard';
import NegotiatorDashboard from './dashboards/NegotiatorDashboard';
import GuestDashboard from './dashboards/GuestDashboard';
import SellerDashboard from './dashboards/SellerDashboard';
import AdminDashboard from './dashboards/AdminDashboard';

interface DashboardProps {
  userRole: UserRole;
  userName: string;
}

const Dashboard: React.FC<DashboardProps> = ({ userRole, userName }) => {
  const renderDashboard = () => {
    switch (userRole) {
      case 'couple':
        return <CouplesDashboard userName={userName} />;
      case 'pro':
        return <ProDashboard userName={userName} />;
      case 'venue':
        return <VenueDashboard userName={userName} />;
      case 'negotiator':
        return <NegotiatorDashboard userName={userName} />;
      case 'guest':
        return <GuestDashboard userName={userName} />;
      case 'seller':
        return <SellerDashboard userName={userName} />;
      case 'admin':
        return <AdminDashboard userName={userName} />;
      default:
        return <CouplesDashboard userName={userName} />;
    }
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {renderDashboard()}
    </div>
  );
};

export default Dashboard;
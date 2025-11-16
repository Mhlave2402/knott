<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VendorApplication;
use App\Models\Dispute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_requires_authentication()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard_requires_admin_role()
    {
        $user = User::factory()->create(['role' => 'couple']);
        
        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_all_admin_routes()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $routes = [
            '/admin/dashboard',
            '/admin/vendor-approvals',
            '/admin/disputes',
            '/admin/competitions',
            '/admin/analytics'
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($admin)->get($route);
            $this->assertTrue(in_array($response->status(), [200, 302]), 
                "Route {$route} failed with status {$response->status()}");
        }
    }

    public function test_admin_actions_are_logged()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $application = VendorApplication::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patch("/admin/vendor-approvals/{$application->id}/approve");

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'vendor_application_approved'
        ]);
    }

    public function test_sensitive_data_is_encrypted()
    {
        $user = User::factory()->create([
            'role' => 'vendor',
            'tax_number' => '1234567890'
        ]);

        $rawData = \DB::table('users')->where('id', $user->id)->first();
        $this->assertNotEquals('1234567890', $rawData->tax_number);
    }
}
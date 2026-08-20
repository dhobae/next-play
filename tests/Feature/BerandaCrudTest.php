<?php

namespace Tests\Feature;

use App\Models\BerandaCarousel;
use App\Models\BerandaSponsor;
use App\Models\TentangkamiVisimisi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BerandaCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_carousel_and_sponsor_pages(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.carousel.index'));
        $response->assertOk();
        $response->assertViewIs('admin.beranda.carousel.index');

        $response = $this->actingAs($user)->get(route('admin.sponsor.index'));
        $response->assertOk();
        $response->assertViewIs('admin.beranda.sponsor.index');
    }

    public function test_admin_can_create_update_and_delete_carousel(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('carousel.jpg');

        $this->actingAs($user)
            ->post(route('admin.carousel.store'), [
                'judul' => 'Judul Baru',
                'subjudul' => 'Subjudul Baru',
                'gambar' => $file,
            ])
            ->assertRedirect();

        $carousel = BerandaCarousel::first();
        $this->assertNotNull($carousel);
        $this->assertEquals('Judul Baru', $carousel->judul);

        $this->actingAs($user)
            ->put(route('admin.carousel.update', $carousel->id), [
                'judul' => 'Judul Update',
                'subjudul' => 'Subjudul Update',
                'gambar' => UploadedFile::fake()->image('carousel-update.jpg'),
            ])
            ->assertRedirect();

        $carousel->refresh();
        $this->assertEquals('Judul Update', $carousel->judul);

        $this->actingAs($user)
            ->delete(route('admin.carousel.destroy', $carousel->id))
            ->assertRedirect();

        $this->assertDatabaseMissing('beranda_carousel', ['id' => $carousel->id]);
    }

    public function test_admin_can_create_update_and_delete_sponsor(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.sponsor.store'), [
                'nama_sponsor' => 'Sponsor A',
                'gambar' => UploadedFile::fake()->image('sponsor.jpg'),
            ])
            ->assertRedirect();

        $sponsor = BerandaSponsor::first();
        $this->assertNotNull($sponsor);
        $this->assertEquals('Sponsor A', $sponsor->nama_sponsor);

        $this->actingAs($user)
            ->put(route('admin.sponsor.update', $sponsor->id), [
                'nama_sponsor' => 'Sponsor B',
                'gambar' => UploadedFile::fake()->image('sponsor-update.jpg'),
            ])
            ->assertRedirect();

        $sponsor->refresh();
        $this->assertEquals('Sponsor B', $sponsor->nama_sponsor);

        $this->actingAs($user)
            ->delete(route('admin.sponsor.destroy', $sponsor->id))
            ->assertRedirect();

        $this->assertDatabaseMissing('beranda_sponsor', ['id' => $sponsor->id]);
    }

    public function test_admin_can_view_visimisi_page_and_manage_it(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.visimisi.index'));
        $response->assertOk();
        $response->assertViewIs('admin.ttgkami.visimisi.index');

        $this->actingAs($user)
            ->post(route('admin.visimisi.store'), [
                'visi' => '<p>Menjadi klub terbaik.</p>',
                'misi' => '<ol><li>Menumbuhkan semangat olahraga.</li><li>Mengembangkan potensi atlet.</li></ol>',
                'gambar' => UploadedFile::fake()->image('visimisi.jpg'),
            ])
            ->assertRedirect();

        $visimisi = TentangkamiVisimisi::first();
        $this->assertNotNull($visimisi);
        $this->assertStringContainsString('klub terbaik', $visimisi->visi);

        $this->actingAs($user)
            ->put(route('admin.visimisi.update', $visimisi->id), [
                'visi' => '<p>Menjadi klub nomor satu.</p>',
                'misi' => '<ol><li>Menjadi teladan.</li><li>Memajukan prestasi.</li></ol>',
                'gambar' => UploadedFile::fake()->image('visimisi-update.jpg'),
            ])
            ->assertRedirect();

        $visimisi->refresh();
        $this->assertStringContainsString('nomor satu', $visimisi->visi);

        $this->actingAs($user)
            ->delete(route('admin.visimisi.destroy', $visimisi->id))
            ->assertRedirect();

        $this->assertDatabaseMissing('tentangkami_visimisi', ['id' => $visimisi->id]);
    }
}

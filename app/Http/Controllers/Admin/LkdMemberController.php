<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lkd\StoreMemberRequest;
use App\Http\Requests\Lkd\UpdateMemberRequest;
use App\Models\Lkd;
use App\Models\LkdMember;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LkdMemberController extends Controller
{
    public function store(StoreMemberRequest $request, Lkd $lkd) {
        $data = $request->validated();
        $data['lkd_id']   = $lkd->id;
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $data['order_no'] = $data['order_no'] ?? ($lkd->members()->max('order_no') + 1);

        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $datePath = now()->format('Y/m/d');
            // tetap di namespace "berita/lkd/members" agar 1 pola dengan Berita
            $dir      = "berita/lkd/members/{$datePath}";
            $name     = Str::random(40).'.'.$file->getClientOriginalExtension();
            $path     = $file->storeAs($dir, $name, 'public');
            $data['foto_path'] = $path;
        }

        $lkd->members()->create($data);
        return back()->with('success','Anggota ditambahkan.');
    }

    public function update(UpdateMemberRequest $request, Lkd $lkd, LkdMember $member) {
        $data = $request->validated();
        $data['is_active'] = (bool)($data['is_active'] ?? true);

        if ($request->hasFile('foto')) {
            if ($member->foto_path && Storage::disk('public')->exists($member->foto_path)) {
                Storage::disk('public')->delete($member->foto_path);
            }
            $file     = $request->file('foto');
            $datePath = now()->format('Y/m/d');
            $dir      = "berita/lkd/members/{$datePath}";
            $name     = Str::random(40).'.'.$file->getClientOriginalExtension();
            $path     = $file->storeAs($dir, $name, 'public');
            $data['foto_path'] = $path;
        }

        $member->update($data);
        return back()->with('success','Anggota diperbarui.');
    }

    public function destroy(Lkd $lkd, LkdMember $member) {
        $member->delete(); // foto ikut terhapus via model event
        return back()->with('success','Anggota dihapus.');
    }
}

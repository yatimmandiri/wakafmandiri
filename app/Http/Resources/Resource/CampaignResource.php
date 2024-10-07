<?php

namespace App\Http\Resources\Resource;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $total_donation = Donation::where('status', 'Success')
            ->where('campaign_id', $this->id)
            ->sum(DB::raw('quantity * nominal_donasi + unik_nominal'));

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'description' => $this->description,
            'template' => $this->template,
            'nominal' => $this->nominal,
            'nominal_choice' => $this->nominal_choice,
            'feature_image' => $this->feature_image,
            'status' => $this->status,
            'recomendation' => $this->recomendation,
            'views' => $this->views,
            'paket_id' => $this->paket_id,
            'categories_id' => $this->categories_id,
            'relationship' => [
                'total_donation' => $total_donation,
                'categories' => $this->categories,
                // 'donations' => $this->donations,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\JobOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;

class ComplaintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citizen = User::where('role', 'citizen')->first();

        $potholeCategory = Category::where('name', 'صيانة حفريات او هبوط')->first();
        $rainWaterCategory = Category::where('name', 'تجمع مياه الامطار')->first();
        $sidewalkCategory = Category::where('name', 'استغلال رصيف/ عوائق')->first();
        $healthCategory = Category::where('name', 'منشأة تجارية / عرض مواد غذائية على الرصيف')->first();

        $complaints = [
            [
            'id'=>1,
            'title' => 'هبوط حاد في الشارع الرئيسي',
            'description' => 'يوجد هبوط حاد وتشققات عميقة في الشارع الرئيسي تؤثر على حركة السيارات وتسبب أضراراً للمركبات. يرجى صيانتها بأسرع وقت.',
            'latitude' => '31.963158',
            'longitude' => '35.936274',
            'status' => 'pending',
            'category_id' => $potholeCategory->id,
            'user_id' => $citizen->id,
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
            ],
            [
            'id'=>2,
            'title' => 'تجمع مياه الامطار و إغلاق المنهل',
            'description' => 'مياه الامطار تتجمع بشكل كبير في الشارع بسبب انسداد منهل تصريف المياه، مما يعيق حركة المشاة و السيارات',
            'latitude' => '31.9600',
            'longitude' => '35.9200',
            'status' => 'pending',
            'category_id' => $rainWaterCategory->id,
            'user_id' => $citizen->id,
            'created_at' => now()->subHours(5),
            'updated_at' => now()->subHours(5)
            ],
            [
            'id' => 3,
            'title' => 'استغلال الرصيف من قبل محل تجاري',
            'description' => 'يقوم صاحب المحل بعرض بضائعه و حواجز حديدية على كامل الرصيف مما يمنع المشاة من المرور و يضطرهم للمشي في الشارع العام',
            'latitude' => '31.9600',
            'longitude' => '35.9200',
            'status' => 'pending',
            'category_id' => $sidewalkCategory->id,
            'user_id' => $citizen->id,
            'created_at' => now()->subDays(4),
            'updated_at' => now()->subDays(4)
            ]
        ];

        foreach($complaints as $data){
            Complaint::create($data);
            JobOrder::create([
                'complaint_id' => $data['id']
            ]);
        }
    }
}

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
        $wasteCategory = Category::where('name', 'تراكم النفايات')->first();
        $sweageCategory = Category::where('name', 'رفع و تنزيل و تركيب منهل')->first();
        $animalCategory = Category::where('name', 'أفراد-منازل/تربية حيوانات تؤدي الى ضرر-عدا المرخص')->first();

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
            'created_at' => now()->subHours(2),
            'updated_at' => now()->subHours(2),
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
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1)
            ],[
            'id'=>4,
            'title' => 'قطيع من الكلاب الضالة يهاجم السكان',
            'description' => 'تواجد مستمر لعدد من الكلاب الضالة في الحي و تشكل خطراً على السكان، خاصة الأطفال. يرجى التعامل مع هذا الموضوع بأسرع وقت ممكن.',
            'latitude' => '31.963158',
            'longitude' => '35.936274',
            'status' => 'pending',
            'category_id' => $animalCategory->id,
            'user_id' => $citizen->id,
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
            ],
            [
            'id'=>5,
            'title' => 'فقدان غطاء منهل تصريف المياه و تراكم مياه الامطار',
            'description' => 'تم سرقة غطاء منهل تصريف المياه مما أدى إلى تراكم مياه الامطار في الشارع و أصبح يشكل خطر على المركبات والمارة. يرجى استبدال الغطاء بأسرع وقت ممكن.',
            'latitude' => '31.9600',
            'longitude' => '35.9200',
            'status' => 'pending',
            'category_id' => $sweageCategory->id,
            'user_id' => $citizen->id,
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(3)
            ],
            [
            'id' => 6,
            'title' => 'تراكم النفايات و عدم تفريغ الحاويات',
            'description' => 'يقوم صاحب المحل بعرض بضائعه و حواجز حديدية على كامل الرصيف مما يمنع المشاة من المرور و يضطرهم للمشي في الشارع العامحاويات القمامة ممتلئة والنفايات تتراكم في الشارع منذ 3 أيام. الرائحة أصبحت لا تحتمل وبدأت الحشرات بالتجمع بكثرة حول المنطقة السكنية.',
            'latitude' => '31.9600',
            'longitude' => '35.9200',
            'status' => 'pending',
            'category_id' => $wasteCategory->id,
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

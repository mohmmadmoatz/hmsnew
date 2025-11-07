<?php

namespace Database\Seeders;

use App\Models\LabStockCategory;
use App\Models\LabStockItem;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LabStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create stock categories
        $categories = [
            [
                'name' => 'الأدوية',
                'code' => 'MED',
                'description' => 'الأدوية والمستحضرات الطبية',
                'color' => '#e3f2fd',
                'icon' => 'fa-pills',
                'sort_order' => 1,
            ],
            [
                'name' => 'المعدات الطبية',
                'code' => 'EQUIP',
                'description' => 'المعدات والأدوات الطبية',
                'color' => '#f3e5f5',
                'icon' => 'fa-stethoscope',
                'sort_order' => 2,
            ],
            [
                'name' => 'المواد الكيميائية',
                'code' => 'CHEM',
                'description' => 'المواد الكيميائية للتحاليل المخبرية',
                'color' => '#fff3e0',
                'icon' => 'fa-flask',
                'sort_order' => 3,
            ],
            [
                'name' => 'الأدوات المعملية',
                'code' => 'LAB',
                'description' => 'الأدوات والمواد المعملية',
                'color' => '#e8f5e8',
                'icon' => 'fa-microscope',
                'sort_order' => 4,
            ],
            [
                'name' => 'المواد الاستهلاكية',
                'code' => 'CONSUM',
                'description' => 'المواد الاستهلاكية والمستلزمات',
                'color' => '#fce4ec',
                'icon' => 'fa-box-open',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            LabStockCategory::create($category);
        }

        // Create sample stock items
        $items = [
            [
                'name' => 'أموكسيسيلين 500 مجم',
                'code' => 'AMOX-500',
                'category' => 'الأدوية',
                'description' => 'مضاد حيوي واسع المجال',
                'quantity' => 150,
                'min_quantity' => 20,
                'unit_price' => 2.50,
                'supplier' => 'شركة الأدوية الوطنية',
                'purchase_date' => Carbon::now()->subDays(30),
                'expiry_date' => Carbon::now()->addDays(180),
                'batch_number' => 'AMX20241101',
                'location' => 'رف 3 - درج 2',
                'notes' => 'يحفظ في درجة حرارة الغرفة',
                'created_by' => 5,
                'days_before_expiry_notification' => 30,
            ],
            [
                'name' => 'إنسولين سريع المفعول',
                'code' => 'INS-REG',
                'category' => 'الأدوية',
                'description' => 'إنسولين لمرضى السكري',
                'quantity' => 25,
                'min_quantity' => 10,
                'unit_price' => 15.00,
                'supplier' => 'مستشفى الملك فيصل',
                'purchase_date' => Carbon::now()->subDays(15),
                'expiry_date' => Carbon::now()->addDays(90),
                'batch_number' => 'INS20241115',
                'location' => 'ثلاجة الأدوية - رف 1',
                'notes' => 'يحفظ في الثلاجة - درجة حرارة 2-8 مئوية',
                'created_by' => 5,
                'days_before_expiry_notification' => 30,
            ],
            [
                'name' => 'محلول كلوريد الصوديوم 0.9%',
                'code' => 'NACL-09',
                'category' => 'المواد الاستهلاكية',
                'description' => 'محلول ملحي طبيعي',
                'quantity' => 200,
                'min_quantity' => 50,
                'unit_price' => 1.20,
                'supplier' => 'شركة المحاليل الطبية',
                'purchase_date' => Carbon::now()->subDays(45),
                'expiry_date' => Carbon::now()->addDays(365),
                'batch_number' => 'NACL20240901',
                'location' => 'مخزن المحاليل',
                'notes' => 'محلول معقم - لا يحتاج لتبريد',
                'created_by' => 5,
                'days_before_expiry_notification' => 60,
            ],
            [
                'name' => 'أنابيب اختبار 10 مل',
                'code' => 'TUBE-10ML',
                'category' => 'الأدوات المعملية',
                'description' => 'أنابيب اختبار زجاجية 10 مل',
                'quantity' => 500,
                'min_quantity' => 100,
                'unit_price' => 0.50,
                'supplier' => 'شركة الأدوات المعملية',
                'purchase_date' => Carbon::now()->subDays(20),
                'expiry_date' => Carbon::now()->addYears(5),
                'batch_number' => 'TUBE20241101',
                'location' => 'رف الأدوات - درج 1',
                'notes' => 'أدوات زجاجية - يجب الحذر عند الاستخدام',
                'created_by' => 5,
                'days_before_expiry_notification' => 365,
            ],
            [
                'name' => 'كيت تحليل السكر في الدم',
                'code' => 'GLUCOSE-KIT',
                'category' => 'المعدات الطبية',
                'description' => 'كيت تحليل السكر في الدم السريع',
                'quantity' => 30,
                'min_quantity' => 5,
                'unit_price' => 25.00,
                'supplier' => 'شركة التحاليل الطبية',
                'purchase_date' => Carbon::now()->subDays(10),
                'expiry_date' => Carbon::now()->addDays(60),
                'batch_number' => 'GLU20241120',
                'location' => 'ثلاجة المعدات - رف 2',
                'notes' => 'يحفظ في الثلاجة - صالح لمدة شهرين من تاريخ الفتح',
                'created_by' => 5,
                'days_before_expiry_notification' => 14,
            ],
            [
                'name' => 'محلول الهيدروجين بيروكسايد 3%',
                'code' => 'H2O2-3',
                'category' => 'المواد الكيميائية',
                'description' => 'محلول بيروكسيد الهيدروجين للتنظيف',
                'quantity' => 80,
                'min_quantity' => 15,
                'unit_price' => 3.50,
                'supplier' => 'مختبر الكيماويات',
                'purchase_date' => Carbon::now()->subDays(7),
                'expiry_date' => Carbon::now()->addDays(30),
                'batch_number' => 'H2O220241125',
                'location' => 'خزانة المواد الكيميائية - رف 3',
                'notes' => 'مادة مؤكسدة - يجب ارتداء معدات السلامة',
                'created_by' => 5,
                'days_before_expiry_notification' => 7,
            ],
            [
                'name' => 'قفازات فحص طبية',
                'code' => 'GLOVES-EXAM',
                'category' => 'المواد الاستهلاكية',
                'description' => 'قفازات فحص طبية معقمة',
                'quantity' => 1000,
                'min_quantity' => 200,
                'unit_price' => 0.15,
                'supplier' => 'شركة المستلزمات الطبية',
                'purchase_date' => Carbon::now()->subDays(5),
                'expiry_date' => Carbon::now()->addYears(3),
                'batch_number' => 'GLOVE20241125',
                'location' => 'مخزن المستلزمات',
                'notes' => 'قفازات معقمة - تحقق من التلف قبل الاستخدام',
                'created_by' => 5,
                'days_before_expiry_notification' => 180,
            ],
            [
                'name' => 'ميزان إلكتروني دقيق',
                'code' => 'SCALE-PRECISION',
                'category' => 'المعدات الطبية',
                'description' => 'ميزان إلكتروني للقياس الدقيق',
                'quantity' => 3,
                'min_quantity' => 1,
                'unit_price' => 150.00,
                'supplier' => 'شركة المعدات الطبية',
                'purchase_date' => Carbon::now()->subDays(90),
                'expiry_date' => Carbon::now()->addYears(10),
                'batch_number' => 'SCALE20240801',
                'location' => 'غرفة المعدات - طاولة 2',
                'notes' => 'يحتاج لمعايرة دورية',
                'created_by' => 5,
                'days_before_expiry_notification' => 365,
            ],
        ];

        foreach ($items as $item) {
            LabStockItem::create($item);
        }

        $this->command->info('Lab stock data seeded successfully!');
    }
}

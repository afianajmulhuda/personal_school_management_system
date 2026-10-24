<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Campus;
use App\Models\AcademicYears;
use App\Models\classes; // Custom model name mapping the 'classes' table
use App\Models\Sections;
use App\Models\Guardians;
use App\Models\Students;
use App\Models\Student_Enrollments;
use App\Models\Subjects;
use App\Models\Exam_Terms;
use App\Models\Exams;
use App\Models\Marks;
use App\Models\ExamInvoice;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database schema.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // 1. Safe Structural Wipe (Order matches inverse dependencies)
        Schema::disableForeignKeyConstraints();
        ExamInvoice::truncate();
        Marks::truncate();
        Exams::truncate();
        Exam_Terms::truncate();
        Subjects::truncate();
        Student_Enrollments::truncate();
        Students::truncate();
        Guardians::truncate();
        Sections::truncate();
        classes::truncate();
        AcademicYears::truncate();
        Campus::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Seed Users Table (10 Users)
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => "user{$i}@school.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]);
        }

        // 3. Seed Campus & Infrastructure Nodes
        $campuses = [];
        $campusData = [
            ['name' => 'Main Downtown Campus', 'code' => 'MDC', 'location' => '742 Evergreen Terrace'],
            ['name' => 'West Riverside Complex', 'code' => 'WRC', 'location' => '112 Ocean Drive']
        ];
        foreach ($campusData as $data) {
            $campuses[] = Campus::create($data);
        }

        // 4. Seed Academic Calendar Parameters
        $academicYear = AcademicYears::create([
            'name' => '2026-2027',
            'start_date' => '2026-09-01',
            'end_date' => '2027-06-15',
            'is_active' => true,
            'is_closed' => false,
        ]);

        // 5. Seed Core Academic Grade Classes
        $class7 = classes::create(['name' => 'Grade 7', 'numeric_level' => 7, 'next_class_id' => null]);
        $class6 = classes::create(['name' => 'Grade 6', 'numeric_level' => 6, 'next_class_id' => $class7->id]);
        
        $classes = [$class6, $class7];

        // 6. Seed Campus Sections Matrix
        $sections = [];
        foreach ($campuses as $campus) {
            foreach ($classes as $class) {
                $sections[] = Sections::create([
                    'campus_id' => $campus->id,
                    'class_id' => $class->id,
                    'name' => 'Section Blue',
                    'capacity' => 35,
                    'room_number' => 'Room ' . rand(101, 305),
                ]);
            }
        }

        // 7. Seed General Curriculum Course Subjects
        $subjects = [
            Subjects::create(['name' => 'Mathematics', 'code' => 'MATH-301', 'is_elective' => false]),
            Subjects::create(['name' => 'Computational Science', 'code' => 'CS-102', 'is_elective' => false]),
            Subjects::create(['name' => 'World History', 'code' => 'HIST-22', 'is_elective' => true])
        ];

        // 8. Seed Examination Term Frameworks
        $examTerm = Exam_Terms::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Fall Midterm Cycle',
            'weightage' => 40
        ]);

        // 9. Seed 10 Complete Student Profiles and Dependancies
        $genders = ['Male', 'Female', 'Non-Binary'];
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+'];

        for ($i = 1; $i <= 10; $i++) {
            // A. Create unique Guardian profile record per student
            $guardian = Guardians::create([
                'father_name' => $faker->name('male'),
                'father_phone' => $faker->phoneNumber,
                'father_profession' => $faker->jobTitle,
                'mother_name' => $faker->name('female'),
                'mother_phone' => $faker->phoneNumber,
                'mother_profession' => $faker->jobTitle,
                'emergency_contact_name' => $faker->name,
                'emergency_contact_phone' => $faker->phoneNumber,
                'emergency_relation' => $faker->randomElement(['Uncle', 'Aunt', 'Grandparent']),
                'guardian_email' => "guardian{$i}@example.com",
                'residential_address' => $faker->address,
            ]);

            // Pick randomized setup configurations
            $targetSection = $faker->randomElement($sections);
            
            // B. Create Core Student Identity Card Row
            $student = Students::create([
                'admission_no' => 'ADM-2026-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'campus_id' => $targetSection->campus_id,
                'guardian_id' => $guardian->id,
                'first_name' => $faker->firstName,
                'middle_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'date_of_birth' => $faker->date('Y-m-d', '2015-01-01'),
                'gender' => $faker->randomElement($genders),
                'blood_group' => $faker->randomElement($bloodGroups),
                'nationality' => 'Citizen',
                'religion' => $faker->randomElement(['Islam', 'Christianity', 'Hinduism', 'Buddhism']),
                'student_phone' => $faker->optional(0.5)->phoneNumber,
                'student_email' => "student{$i}@school-student.com",
                'current_address' => $guardian->residential_address,
                'permanent_address' => $guardian->residential_address,
                'registration_date' => now()->toDateString(),
                'status' => 'ACTIVE',
                'photo_url' => 'https://placehold.co/150x150.png?text=Student+' . $i,
            ]);

            // C. Establish Student Active Class Term Enrollment Index
            $enrollment = Student_Enrollments::create([
                'student_id' => $student->id,
                'academic_year_id' => $academicYear->id,
                'campus_id' => $targetSection->campus_id,
                'class_id' => $targetSection->class_id,
                'section_id' => $targetSection->id,
                'roll_no' => $i, // Guaranteed unique within this single index loop run configuration
                'enrollment_status' => 'PROMOTED',
            ]);

            // D. Generate Academic Invoice Ledgers
            ExamInvoice::create([
                'student_enrollment_id' => $enrollment->id,
                'exam_term_id' => $examTerm->id,
                'amount_due' => 150.00,
                'amount_paid' => 150.00,
                'status' => 'Paid',
                'due_date' => now()->addDays(14)->toDateString(),
                'payment_date' => now()->toDateString(),
            ]);
        }

        // 10. Seed Exams and Marks sheets across active profiles
        // Pull all enrollments back out to map exam objects safely
        $allEnrollments = Student_Enrollments::all();
        
        foreach ($sections as $section) {
            // Find students enrolled in this exact classroom intersection node
            $sectionEnrollments = $allEnrollments->where('section_id', $section->id);
            
            if ($sectionEnrollments->isEmpty()) {
                continue;
            }

            foreach ($subjects as $subject) {
                // Create the scheduled Exam item instance
                $exam = Exams::create([
                    'exam_term_id' => $examTerm->id,
                    'section_id' => $section->id,
                    'subject_id' => $subject->id,
                    'exam_date' => now()->addDays(2)->toDateString(),
                    'max_marks' => 100.00,
                    'min_passing_marks' => 40.00
                ]);

                // Record grade sheets rows for each student attending this exam room instance
                foreach ($sectionEnrollments as $enrollment) {
                    Marks::create([
                        'exam_id' => $exam->id,
                        'student_enrollment_id' => $enrollment->id,
                        'marks_obtained' => $faker->randomFloat(2, 45, 98),
                        'is_absent' => false,
                        'teacher_remarks' => $faker->randomElement(['Excellent logic tracking', 'Good progress', 'Satisfactory metrics balance']),
                    ]);
                }
            }
        }
    }
}
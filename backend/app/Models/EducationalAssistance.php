<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalAssistance extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
protected $fillable = [
        'representative_lastname',
        'representative_firstname',
        'representative_middlename',
        'representative_birthday',
        'representative_gender',
        'representative_age',
        'beneficiary_lastname',
        'beneficiary_firstname',
        'beneficiary_middlename',
        'beneficiary_birthday',
        'beneficiary_age',
        'beneficiary_gender',
        'relationship_to_beneficiary',
        'contact_number',
        'province',
        'municipality',
        'barangay',
        'sitio',
        'school',
        'school_level',
        'year_level',
        'academic_year_stage',
        'student_email',
        'code',
        'status',
        'educational_assistance_type',
        'barangay_indigency_imagepath',
        'valid_id_imagepath',
        'certificate_of_enrollment_imagepath',
        'certificate_of_registration_imagepath',
    ];
}

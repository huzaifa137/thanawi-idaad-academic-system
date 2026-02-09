<?php
namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\User;
use App\Models\Student;
use App\Models\AcademicYear;

class Helper extends Controller
{
    public static function user_id()
    {
        return $user = Session::get('LoggedAdmin');
    }

    public static function logged_admin_user()
    {
        if (Session::has('LoggedAdmin')) {
            return User::where('id', Session::get('LoggedAdmin'))
                ->value('name');
        }

        if (Session::has('LoggedStudent')) {
            return User::where('id', Session::get('LoggedStudent'))
                ->value('name');
        }

        return 'Guest';
    }

    public static function student_username($user = "")
    {
        $user = (int) $user;
        return DB::table('users')
            ->where('id', $user)
            ->where('user_role', 1)
            ->value('id');
    }

    public static function get_teacher_name($teacher_id)
    {
        $teacher_id = (int) $teacher_id;

        return DB::table('teachers')
            ->where('id', $teacher_id)
            ->value('firstname') ?? 'No Record Found';
    }

    public static function category_name($user = "")
    {
        $user = (int) $user;
        $admin = DB::table('users')->where('id', '=', $user)->where('user_role', '!=', 1)->first();

        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function language_name($user = "")
    {
        $user = (int) $user;
        $admin = DB::table('users')->where('id', '=', $user)->where('user_role', '!=', 1)->first();

        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function active_user()
    {

        $admin = DB::table('users')->where('id', '=', Session('LoggedAdmin'))->first();
        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function item_md_name($md_id)
    {
        $md_name = DB::table('master_datas')
            ->where('md_id', $md_id)
            ->value('md_name');

        return $md_name;
    }

    public static function item_md_id($md_name)
    {
        $md_id = DB::table('master_datas')
            ->where('md_name', $md_name)
            ->value('md_id');

        return $md_id;
    }

    public static function studentStream($studentId)
    {
        $studentStream = DB::table('students')
            ->where('id', $studentId)
            ->value('stream');

        return $studentStream;
    }

    public static function course_information($course_id)
    {
        $courseName = DB::table('courses')
            ->where('id', $course_id)
            ->value('title');

        return $courseName;
    }

    public static function DropMasterData($code_id = "", $selected = "", $id = "", $part = 2, $disabled = 0)
    {

        if (!$code_id) {
            $select = DB::table("master_datas")->get();
        } else {
            $select = DB::table("master_datas")->where("md_master_code_id", $code_id)->orderBy("md_name", "asc")->get();
        }

        $disabled = ($disabled) ? "disabled" : "";

        $string = "";
        $string .= '<select name="' . $id . '" id="' . $id . '" class="form-control select2" ' . $disabled . '>';
        $string .= '<option value=""> -- Select -- </option>';
        foreach ($select as $row) {
            if ($part == 1) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . '</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . '</option>';
                }

            } else if ($part == 2) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                }

            }
        }

        $string .= '</select>';

        return $string;
    }

    public static function DropMasterDataAsc($code_id = "", $selected = "", $id = "", $part = 2, $disabled = 0)
    {

        if (!$code_id) {
            $select = DB::table("master_datas")->get();
        } else {
            $select = DB::table("master_datas")->where("md_master_code_id", $code_id)->orderBy("md_id", "asc")->get();
        }

        $disabled = ($disabled) ? "disabled" : "";

        $string = "";
        $string .= '<select name="' . $id . '" id="' . $id . '" class="form-control" ' . $disabled . '>';
        $string .= '<option value=""> -- Select -- </option>';
        foreach ($select as $row) {
            if ($part == 1) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . '</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . '</option>';
                }

            } else if ($part == 2) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                }

            }
        }

        $string .= '</select>';

        return $string;
    }

    public static function MasterRecord($md_master_code_id, $md_id)
    {

        $md_id = (string) $md_id;

        $masterRecord = DB::table('master_datas')
            ->where('md_master_code_id', $md_master_code_id)
            ->where('md_id', operator: $md_id)
            ->value('md_name');

        return $masterRecord;

    }

    public static function MasterRecordMdId($md_id)
    {
        $md_id = (string) $md_id;
        $masterRecord = DB::table('master_datas')
            ->where('md_id', operator: $md_id)
            ->value('md_name');

        return $masterRecord;

    }

    public static function recordMdname($md_id)
    {
        $recordName = DB::table('master_datas')
            ->where('md_id', operator: $md_id)
            ->value('md_name');

        return $recordName;
    }


    public static function MasterRecordMerge($item1, $item2)
    {
        $items = [$item1, $item2];

        $records = DB::table('master_datas')
            ->whereIn('md_master_code_id', $items)
            ->get();

        return $records;
    }


    public static function fetchAllSubjects()
    {

        $Technical_Subjects = config('constants.options.TECHNICAL_SUBJECTS');
        $Mathematics = config('constants.options.MATHEMATICS');
        $Languages = config('constants.options.LANGUAGES');
        $Sciences = config('constants.options.SCIENCES');
        $Humanities = config('constants.options.HUMANITIES');

        $items = [$Technical_Subjects, $Mathematics, $Languages, $Sciences, $Humanities];

        $records = DB::table('master_datas')
            ->whereIn('md_master_code_id', $items)
            ->get();

        return $records;
    }


    public static function MasterRecords($md_master_code_id)
    {
        $records = DB::table('master_datas')
            ->where('md_master_code_id', $md_master_code_id)
            ->get();

        return $records;
    }

    public static function active_year()
    {
        $activeYear = AcademicYear::where('is_active', 1)
            ->orderBy('id', 'desc')
            ->value('name');

        return $activeYear ?? 'No Active year Set';
    }

    public static function schoolStudentsCount($school_id)
    {
        return Student::where('school_id', $school_id)->count();
    }

    public static function db_item_from_column($db_table, $item_id, $item_column)
    {
        $specificItem = DB::table($db_table)
            ->where('id', $item_id)
            ->value($item_column);

        return $specificItem;
    }

    public static function school_student_fullName($user = "")
    {
        $user = (int) $user;

        return DB::table('students')
            ->where('id', $user)
            ->select(DB::raw("CONCAT(firstname, ' ', lastname) as full_name"))
            ->value('full_name');
    }

    public static function gradeFromAverage($average)
    {

        // English and Arabic 

        // if ($average >= 80 && $average <= 100) {
        //     return 'Mumtaz/ممتاز';
        // } elseif ($average >= 70 && $average < 80) {
        //     return 'Jayid Jiddan/جيد جدًا';
        // } elseif ($average >= 60 && $average < 70) {
        //     return 'Jayid/جيد';
        // } elseif ($average >= 50 && $average < 60) {
        //     return 'Maqbul/مقبول';
        // } else {
        //     return 'Rasib/راسب';
        // }

        // English Alone

        // if ($average >= 80 && $average <= 100) {
        //     return 'Mumtaz';
        // } elseif ($average >= 70 && $average < 80) {
        //     return 'Jayid Jiddan';
        // } elseif ($average >= 60 && $average < 70) {
        //     return 'Jayid';
        // } elseif ($average >= 50 && $average < 60) {
        //     return 'Maqbul';
        // } else {
        //     return 'Rasib';
        // }

        // Arabic Alone

        if ($average >= 80 && $average <= 100) {
            return 'ممتاز';
        } elseif ($average >= 70 && $average < 80) {
            return 'جيد جدًا';
        } elseif ($average >= 60 && $average < 70) {
            return 'جيد';
        } elseif ($average >= 50 && $average < 60) {
            return 'مقبول';
        } else {
            return 'راسب';
        }
    }


    public static function current_logged_school($school_id)
    {
        $schoolName = DB::table('schools')
            ->where('id', operator: $school_id)
            ->value('name');

        return $schoolName;
    }

}

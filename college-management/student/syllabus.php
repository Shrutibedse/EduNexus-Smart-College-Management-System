<?php
$page_title = 'Syllabus';
require_once '../includes/student_header.php';

/* ============================================================
 *  Course information (brief about each course)
 *  Edit the text / duration / SPPU syllabus link as needed.
 * ============================================================ */
$course_info = [
    'BCA' => [
        'full_name'   => 'Bachelor of Computer Application',
        'duration'    => '3 Years (6 Semesters)',
        'eligibility' => 'HSC (12th) with English & any stream',
        'about'       => 'BCA is an undergraduate degree focused on computer applications, programming, software development, database management and modern web technologies. Graduates are well prepared for careers in IT, software engineering and higher studies (MCA / MBA-IT).',
        'sppu_url'    => 'http://www.unipune.ac.in/syllabi_pdf/revised_2019/science/UG_BCA(Science)_2019_Course_Patten.pdf'
    ],
    'BBA' => [
        'full_name'   => 'Bachelor of Business Administration',
        'duration'    => '3 Years (6 Semesters)',
        'eligibility' => 'HSC (12th) any stream',
        'about'       => 'BBA gives a strong foundation in business management, marketing, finance, human resources and entrepreneurship. It builds leadership and analytical skills required for modern corporate roles or further studies like MBA.',
        'sppu_url'    => 'http://www.unipune.ac.in/syllabi_pdf/revised_2019/management/BBA_2019_Pattern.pdf'
    ],
    'B.Com' => [
        'full_name'   => 'Bachelor of Commerce',
        'duration'    => '3 Years (6 Semesters)',
        'eligibility' => 'HSC (12th) Commerce / any stream',
        'about'       => 'B.Com covers accounting, taxation, economics, business law, banking and finance. Ideal for students aiming for careers in CA, CS, banking, finance and corporate accounting.',
        'sppu_url'    => 'http://www.unipune.ac.in/syllabi_pdf/'
    ],
    'BA' => [
        'full_name'   => 'Bachelor of Arts',
        'duration'    => '3 Years (6 Semesters)',
        'eligibility' => 'HSC (12th) any stream',
        'about'       => 'BA covers humanities and social sciences such as English, History, Political Science, Sociology, Psychology and Languages. Develops critical thinking, communication and research skills.',
        'sppu_url'    => 'http://www.unipune.ac.in/syllabi_pdf/'
    ],
    'BSc' => [
        'full_name'   => 'Bachelor of Science',
        'duration'    => '3 Years (6 Semesters)',
        'eligibility' => 'HSC (12th) Science',
        'about'       => 'BSc covers fundamental sciences — Physics, Chemistry, Mathematics, Biology, Computer Science. Strong base for higher studies, research and technology careers.',
        'sppu_url'    => 'http://www.unipune.ac.in/syllabi_pdf/'
    ],
    'MCA' => [
        'full_name'   => 'Master of Computer Application',
        'duration'    => '2 Years (4 Semesters)',
        'eligibility' => 'BCA / BSc-CS / Graduate with Maths',
        'about'       => 'MCA is a postgraduate degree focused on advanced software development, data structures, algorithms, AI/ML, cloud computing and project work. Highly valued in IT industry.',
        'sppu_url'    => 'http://www.unipune.ac.in/syllabi_pdf/revised_2020/Engineering/MCA_2020_Course.pdf'
    ],
    'MBA' => [
        'full_name'   => 'Master of Business Administration',
        'duration'    => '2 Years (4 Semesters)',
        'eligibility' => 'Graduation with valid CET / CAT / MAT score',
        'about'       => 'MBA is a postgraduate management program with specializations in Marketing, Finance, HR, Operations, IT and Analytics. Prepares students for managerial and leadership roles.',
        'sppu_url'    => 'http://www.unipune.ac.in/syllabi_pdf/revised_2020/management/MBA_2020_Pattern.pdf'
    ],
];

$my_course = $_SESSION['student_course'];
$info = $course_info[$my_course] ?? null;

// Fetch syllabus uploaded by teachers for this course/year
$stmt = $conn->prepare("SELECT s.*, t.name AS teacher_name FROM syllabus s LEFT JOIN teachers t ON s.uploaded_by=t.id WHERE s.course=? AND s.year=? ORDER BY s.subject ASC");
$stmt->bind_param('ss', $_SESSION['student_course'], $_SESSION['student_year']);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="page-header">
    <div>
        <h1>Syllabus</h1>
        <p>Course information and subjects for <?= e($_SESSION['student_course']) ?> · <?= e($_SESSION['student_year']) ?></p>
    </div>
</div>

<!-- ===== Course Information ===== -->
<?php if ($info): ?>
<div class="panel">
    <h3 class="panel-title">📘 About <?= e($my_course) ?> — <?= e($info['full_name']) ?></h3>
    <div class="cards" style="margin-bottom:18px;">
        <div class="card accent">
            <div class="label">Course</div>
            <div class="value" style="font-size:20px;"><?= e($my_course) ?></div>
            <div class="sub"><?= e($info['full_name']) ?></div>
        </div>
        <div class="card success">
            <div class="label">Duration</div>
            <div class="value" style="font-size:20px;"><?= e($info['duration']) ?></div>
        </div>
        <div class="card warning">
            <div class="label">Eligibility</div>
            <div class="value" style="font-size:16px;"><?= e($info['eligibility']) ?></div>
        </div>
    </div>
    <p style="color:#334155; line-height:1.7;"><?= e($info['about']) ?></p>
</div>
<?php endif; ?>

<!-- ===== SPPU University Link ===== -->
<div class="panel" style="background:linear-gradient(135deg,#1e3a8a,#0ea5e9); color:#fff;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap;">
        <div>
            <h3 style="color:#fff; font-size:20px; margin-bottom:6px;">🎓 Savitribai Phule Pune University (SPPU)</h3>
            <p style="color:#e0e7ff; font-size:14px;">
                Our college is affiliated to SPPU. Visit the official university portal for the latest syllabus, results, circulars and academic calendar.
            </p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="http://www.unipune.ac.in/" target="_blank" rel="noopener" class="btn btn-secondary">
                🌐 Visit SPPU Website
            </a>
            <?php if ($info && !empty($info['sppu_url'])): ?>
                <a href="<?= e($info['sppu_url']) ?>" target="_blank" rel="noopener" class="btn" style="background:#fff; color:#1e3a8a;">
                    📄 SPPU <?= e($my_course) ?> Syllabus PDF
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ===== Quick Syllabus Links (SPPU & resources) ===== -->
<div class="panel">
    <h3 class="panel-title">🔗 Quick Syllabus Links</h3>
    <div class="cards">
        <div class="card accent">
            <div class="label">SPPU Syllabus Repository</div>
            <div class="sub" style="margin-top:8px;">All courses · all departments · year-wise PDF</div>
            <p style="margin-top:10px;"><a href="http://collegecirculars.unipune.ac.in/sites/documents/Syllabus2025/Forms/AllItems.aspx" target="_blank" rel="noopener" class="btn btn-sm">Open Syllabus Repo →</a></p>
        </div>
        <div class="card success">
            <div class="label">SPPU Academic Calendar</div>
            <div class="sub" style="margin-top:8px;">Current year exams · holidays · key dates</div>
            <p style="margin-top:10px;"><a href="https://beta.unipune.ac.in/university_files/academic_calender.htm" target="_blank" rel="noopener" class="btn btn-sm">View Calendar →</a></p>
        </div>
        <div class="card warning">
            <div class="label">SPPU Examination Section</div>
            <div class="sub" style="margin-top:8px;">Time tables · results · exam forms</div>
            <p style="margin-top:10px;"><a href="https://exam.unipune.ac.in/" target="_blank" rel="noopener" class="btn btn-sm">Exam Portal →</a></p>
        </div>
    </div>
</div>

<!-- ===== Subjects uploaded by teachers ===== -->
<div class="panel">
    <h3 class="panel-title">📚 Subjects &amp; Syllabus — <?= e($_SESSION['student_course']) ?> <?= e($_SESSION['student_year']) ?></h3>
    <?php if($res->num_rows): ?>
        <?php while($s = $res->fetch_assoc()): ?>
            <div class="list-item">
                <h4><?= e($s['subject']) ?></h4>
                <p class="meta">Uploaded by <?= e($s['teacher_name']) ?> · <?= date('d M Y', strtotime($s['created_at'])) ?></p>
                <p><?= nl2br(e($s['description'])) ?></p>
                <p style="margin-top:10px; display:flex; gap:8px; flex-wrap:wrap;">
                    <?php if(!empty($s['file_path'])): ?>
                        <a href="../<?= e($s['file_path']) ?>" target="_blank" class="btn btn-sm">📎 Download Syllabus</a>
                    <?php endif; ?>
                    <?php if($info && !empty($info['sppu_url'])): ?>
                        <a href="<?= e($info['sppu_url']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-light">📄 SPPU Syllabus</a>
                    <?php endif; ?>
                </p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="color:#64748b;">No subjects uploaded by teachers yet for your course/year. You can still refer to the official SPPU syllabus link above.</p>
    <?php endif; ?>
</div>

<?php require_once '../includes/student_footer.php'; ?>

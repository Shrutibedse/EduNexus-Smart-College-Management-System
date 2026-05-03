<?php
require_once 'config/db.php';
$page_title = 'Home';
$base_path = '';
include 'includes/header_public.php';

// Pull a few latest notices/events to display
$notices = $conn->query("SELECT * FROM notices ORDER BY created_at DESC LIMIT 3");
$events  = $conn->query("SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 3");
?>

<section class="hero">
    <h1>Welcome to Dr. Moonje Institute of Management and Computer Studies</h1>
    <p>A modern college management portal — students get instant access to syllabus, fees, exams, notices and events. Teachers manage everything in one place.</p>
    <div class="actions">
        <a href="student/login.php" class="btn btn-secondary">Student Login</a>
        <a href="teacher/login.php" class="btn btn-light">Teacher Login</a>
    </div>
</section>

<section id="features" style="max-width:1200px; margin:0 auto;">
    <div class="section-heading">
        <h2>Everything You Need</h2>
        <p>One simple portal connecting students and teachers</p>
    </div>
    <div class="feature-grid">
        <div class="feature">
            <div class="icon-circle">📚</div>
            <h3>Syllabus</h3>
            <p>Course-wise syllabus with detailed unit descriptions, accessible 24/7.</p>
        </div>
        <div class="feature">
            <div class="icon-circle">💰</div>
            <h3>Fees Tracking</h3>
            <p>View paid, pending and partial fees with due dates at a glance.</p>
        </div>
        <div class="feature">
            <div class="icon-circle">📝</div>
            <h3>Examinations</h3>
            <p>Exam schedules with date, time, venue and duration for every subject.</p>
        </div>
        <div class="feature">
            <div class="icon-circle">📢</div>
            <h3>Notices</h3>
            <p>Latest college announcements posted by faculty in real time.</p>
        </div>
        <div class="feature">
            <div class="icon-circle">🎉</div>
            <h3>Events</h3>
            <p>Upcoming festivals, competitions, sports week and industrial visits.</p>
        </div>
        <div class="feature">
            <div class="icon-circle">📍</div>
            <h3>Get Direction</h3>
            <p>Reach the campus easily with built-in maps and contact information.</p>
        </div>
    </div>
</section>

<section id="about" style="max-width:1200px; margin:30px auto; padding:0 20px;">
    <div class="cards" style="grid-template-columns:1fr 1fr;">
        <div class="panel">
            <h3 class="panel-title">Latest Notices</h3>
            <?php if ($notices->num_rows): while($n=$notices->fetch_assoc()): ?>
                <div class="list-item">
                    <h4><?= e($n['title']) ?></h4>
                    <p class="meta">Posted on <?= date('d M Y', strtotime($n['created_at'])) ?></p>
                    <p><?= e(substr($n['description'], 0, 140)) ?>...</p>
                </div>
            <?php endwhile; else: ?>
                <p style="color:#64748b;">No notices yet.</p>
            <?php endif; ?>
        </div>

        <div class="panel">
            <h3 class="panel-title">Upcoming Events</h3>
            <?php if ($events->num_rows): while($ev=$events->fetch_assoc()): ?>
                <div class="list-item event">
                    <h4><?= e($ev['title']) ?></h4>
                    <p class="meta">📅 <?= date('d M Y', strtotime($ev['event_date'])) ?> · 📍 <?= e($ev['venue']) ?></p>
                    <p><?= e(substr($ev['description'], 0, 140)) ?>...</p>
                </div>
            <?php endwhile; else: ?>
                <p style="color:#64748b;">No upcoming events.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

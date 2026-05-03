<?php
$page_title = 'Get Direction';
require_once '../includes/student_header.php';

/* ============================================================
 *  STEP 1 — REPLACE COORDINATES HERE
 *  --------------------------------------------------------
 *  Change the lat/lng values below with your REAL coordinates.
 *  Format: 'Room Name' => [LATITUDE, LONGITUDE]
 *  Example: 'BBA Classroom' => [19.997480, 73.789850],
 * ============================================================ */
$coordinates = [
    // ----- Ground Floor -----
    'BBA Classroom'             => [19.997480, 73.789850],
    'MBA Classroom'             => [19.997450, 73.789920],
    'Staff Room 1 (MBA)'        => [19.997440, 73.789940],
    'Director Cabin'            => [19.997520, 73.789730],
    'Reception'                 => [19.997500, 73.789780],
    'Guest Room'                => [19.997530, 73.789750],
    'Auditorium'                => [19.997490, 73.789820],
    'Ground (Playground)'       => [19.997380, 73.789880],
    'Boys Common Room'          => [19.997420, 73.789790],
    'Girls Common Room'         => [19.997420, 73.789910],

    // ----- First Floor -----
    'MCA Classroom (Room 5119)' => [19.997520, 73.789830],
    'MCS Classroom (Room 5132)' => [19.997510, 73.789860],
    'Staff Room 2 (MCA)'        => [20.011245, 73.75319], //Done
    'Lab 1'                     => [19.997480, 73.789930],
    'Lab 2'                     => [19.997460, 73.789950],
    'Lab 3'                     => [19.997440, 73.789970],
    'Library'                   => [19.997500, 73.789850],
    'Seminar Hall'              => [19.997490, 73.789870],
    'Sport Room'                => [20.011236, 75.753088], //Done 
];

$campus_lat = 19.997500;
$campus_lng = 73.789850;

/* ============================================================
 *  STEP 2 — (optional) Edit the floor / icon / direction text
 *  --------------------------------------------------------
 *  Coordinates above are merged into the array below by name.
 *  You normally don't need to touch this part.
 * ============================================================ */
$rooms_meta = [
    // ===== Ground Floor =====
    'BBA Classroom' => [
        'floor'     => 'Ground Floor',
        'icon'      => '🏫',
        'direction' => 'Enter through the main entrance, walk straight along the central corridor — the BBA classroom is on the right side, second room.'
    ],
    'MBA Classroom' => [
        'floor'     => 'Ground Floor',
        'icon'      => '🏫',
        'direction' => 'From the main entrance, take the corridor on the right side — the MBA classroom is the last room at the end of the corridor.'
    ],
    'Staff Room 1 (MBA)' => [
        'floor'     => 'Ground Floor',
        'icon'      => '🧑‍🏫',
        'direction' => 'Adjacent to the MBA classroom on the right corridor — the door right after the MBA classroom.'
    ],
    'Director Cabin' => [
        'floor'     => 'Ground Floor',
        'icon'      => '👔',
        'direction' => 'From the reception, walk into the left corridor — the Director\'s cabin is the second door on your left.'
    ],
    'Reception' => [
        'floor'     => 'Ground Floor',
        'icon'      => '🛎️',
        'direction' => 'Reception is right at the main entrance, on your immediate left as you enter the building.'
    ],
    'Guest Room' => [
        'floor'     => 'Ground Floor',
        'icon'      => '🛋️',
        'direction' => 'Near the reception area — opposite to the Director\'s cabin on the ground floor.'
    ],
    'Auditorium' => [
        'floor'     => 'Ground Floor',
        'icon'      => '🎭',
        'direction' => 'Walk straight from the main entrance to the centre of the ground floor — the Auditorium is the large hall ahead.'
    ],
    'Ground (Playground)' => [
        'floor'     => 'Ground Floor',
        'icon'      => '⚽',
        'direction' => 'Exit through the rear door at the back of the ground floor corridor — the playground / college ground is right behind the main building.'
    ],
    'Boys Common Room' => [
        'floor'     => 'Ground Floor',
        'icon'      => '🚹',
        'direction' => 'Ground floor — at the end of the rear corridor on the left side, next to the back exit.'
    ],
    'Girls Common Room' => [
        'floor'     => 'Ground Floor',
        'icon'      => '🚺',
        'direction' => 'Ground floor — at the end of the rear corridor on the right side, opposite the Boys Common Room.'
    ],

    // ===== First Floor =====
    'MCA Classroom (Room 5119)' => [
        'floor'     => 'First Floor',
        'icon'      => '🏫',
        'direction' => 'Take the staircase near the reception. On reaching the first floor, turn left — Room 5119 is the second classroom on the left wing.'
    ],
    'MCS Classroom (Room 5132)' => [
        'floor'     => 'First Floor',
        'icon'      => '🏫',
        'direction' => 'Take the staircase to the first floor and go straight — Room 5132 is right next to the MCA classroom (5119).'
    ],
    'Staff Room 2 (MCA)' => [
        'floor'     => 'First Floor',
        'icon'      => '🧑‍🏫',
        'direction' => 'First floor, near the MCA classroom (Room 5119) — door on the left just before Room 5119.'
    ],
    'Lab 1' => [
        'floor'     => 'First Floor',
        'icon'      => '💻',
        'direction' => 'Take the staircase to the first floor and turn right — Lab 1 is the first computer lab on the right wing.'
    ],
    'Lab 2' => [
        'floor'     => 'First Floor',
        'icon'      => '💻',
        'direction' => 'First floor — Lab 2 is right next to Lab 1 on the right wing corridor.'
    ],
    'Lab 3' => [
        'floor'     => 'First Floor',
        'icon'      => '💻',
        'direction' => 'First floor — Lab 3 is at the end of the right wing corridor, after Lab 1 and Lab 2.'
    ],
    'Library' => [
        'floor'     => 'First Floor',
        'icon'      => '📚',
        'direction' => 'First floor — Library is in the central area of the first floor, directly opposite the Seminar Hall.'
    ],
    'Seminar Hall' => [
        'floor'     => 'First Floor',
        'icon'      => '🎤',
        'direction' => 'First floor — Seminar Hall is in the central area, directly opposite the Library.'
    ],
    'Sport Room' => [
        'floor'     => 'First Floor',
        'icon'      => '🏆',
        'direction' => 'First floor — Sport Room is on the left wing, the last room at the end of the corridor.'
    ],
];

// Merge coordinates into room meta
$rooms = [];
foreach ($rooms_meta as $name => $meta) {
    $coord = $coordinates[$name] ?? [0, 0];
    $rooms[$name] = array_merge($meta, ['lat' => $coord[0], 'lng' => $coord[1]]);
}

// Split rooms by floor
$ground_floor = array_filter($rooms, fn($r) => $r['floor'] === 'Ground Floor');
$first_floor  = array_filter($rooms, fn($r) => $r['floor'] === 'First Floor');
$initial_room = $_GET['room'] ?? '';
?>

<div class="page-header">
    <div>
        <h1>Get Direction</h1>
        <p>Find your way to the campus — and to any classroom inside</p>
    </div>
</div>

<!-- ===== Campus Location ===== -->
<div class="panel">
    <h3 class="panel-title">📍 Campus Location</h3>
    <div class="map-wrap">
        <iframe
            src="https://www.google.com/maps?q=<?= e($campus_lat) ?>,<?= e($campus_lng) ?>&z=17&output=embed"
            allowfullscreen loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <p style="margin-top:16px;">
        <a class="btn"
           href="https://www.google.com/maps/dir/?api=1&destination=<?= e($campus_lat) ?>,<?= e($campus_lng) ?>&travelmode=walking"
           target="_blank">🧭 Open in Google Maps</a>
    </p>

    <div class="contact-info">
        <div class="item">
            <h4>📍 Address</h4>
            <p>Dr. Moonje Institute of Management and Computer Studies, Nashik<br>Maharashtra - 422002</p>
        </div>
        <div class="item">
            <h4>📞 Phone</h4>
            <p>Office: +91 253 2570000<br>Admissions: +91 253 2570011</p>
        </div>
        <div class="item">
            <h4>✉ Email</h4>
            <p>info@moonjecollege.edu<br>admissions@moonjecollege.edu</p>
        </div>
        <div class="item">
            <h4>🕒 Office Hours</h4>
            <p>Mon - Sat: 9:00 AM - 5:00 PM<br>Sun: Closed</p>
        </div>
    </div>
</div>

<!-- ===== Inside Campus Directions ===== -->
<div class="panel">
    <h3 class="panel-title">🏛️ Find Your Classroom / Room</h3>
    <p style="color:#64748b; margin-bottom:18px;">Click any room below to see its <strong>live location on the map</strong> and step-by-step direction inside the building.</p>

    <!-- Selected direction display -->
    <div id="direction-display" style="display:none; margin-bottom:20px;">
        <div class="alert alert-info" style="margin-bottom:0;">
            <h4 id="dir-title" style="margin-bottom:6px; color:#1e40af;"></h4>
            <p id="dir-floor" style="font-size:13px; color:#64748b; margin-bottom:10px;"></p>
            <p id="dir-text" style="margin-bottom:14px;"></p>
            <p id="dir-coords" style="font-size:13px; color:#64748b; margin-bottom:14px;"></p>
            <p id="dir-route" style="font-size:13px; color:#64748b; margin-bottom:14px;"></p>

            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a id="dir-live-btn" href="#" target="_blank" class="btn btn-success">
                    🧭 Get Live Direction (My Location → Here)
                </a>
                <a id="dir-map-btn" href="#" target="_blank" class="btn btn-light">
                    🗺️ Open in Google Maps
                </a>
                <button type="button" id="dir-close" class="btn btn-light">✕ Close</button>
            </div>
        </div>

        <!-- Live embedded map for selected room -->
        <div class="map-wrap" style="margin-top:14px;">
            <iframe id="dir-map-iframe"
                src=""
                allowfullscreen loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <!-- Ground Floor -->
    <h4 style="color:#1e3a8a; margin:18px 0 10px; font-size:17px;">🏠 Ground Floor</h4>
    <div class="room-grid">
        <?php foreach ($ground_floor as $name => $info): ?>
            <button type="button" class="room-btn"
                data-name="<?= e($name) ?>"
                data-floor="<?= e($info['floor']) ?>"
                data-direction="<?= e($info['direction']) ?>"
                data-lat="<?= e($info['lat']) ?>"
                data-lng="<?= e($info['lng']) ?>">
                <span class="room-icon"><?= $info['icon'] ?></span>
                <span class="room-name"><?= e($name) ?></span>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- First Floor -->
    <h4 style="color:#1e3a8a; margin:24px 0 10px; font-size:17px;">🏢 First Floor</h4>
    <div class="room-grid">
        <?php foreach ($first_floor as $name => $info): ?>
            <button type="button" class="room-btn"
                data-name="<?= e($name) ?>"
                data-floor="<?= e($info['floor']) ?>"
                data-direction="<?= e($info['direction']) ?>"
                data-lat="<?= e($info['lat']) ?>"
                data-lng="<?= e($info['lng']) ?>">
                <span class="room-icon"><?= $info['icon'] ?></span>
                <span class="room-name"><?= e($name) ?></span>
            </button>
        <?php endforeach; ?>
    </div>
</div>

<!-- Inline styles & script for the room picker -->
<style>
    .room-grid {
        display:grid;
        grid-template-columns:repeat(auto-fill, minmax(180px, 1fr));
        gap:12px;
    }
    .room-btn {
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        gap:8px;
        padding:18px 12px;
        background:#fff;
        border:2px solid #e2e8f0;
        border-radius:10px;
        cursor:pointer;
        transition:all .2s;
        font-family:inherit;
        text-align:center;
    }
    .room-btn:hover {
        border-color:#1e3a8a;
        background:#eff6ff;
        transform:translateY(-2px);
        box-shadow:0 4px 10px rgba(30,58,138,0.12);
    }
    .room-btn.active {
        border-color:#1e3a8a;
        background:#1e3a8a;
        color:#fff;
    }
    .room-icon { font-size:28px; }
    .room-name { font-size:14px; font-weight:600; color:inherit; }
    .room-btn.active .room-name { color:#fff; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons    = document.querySelectorAll('.room-btn');
    const display    = document.getElementById('direction-display');
    const dTitle     = document.getElementById('dir-title');
    const dFloor     = document.getElementById('dir-floor');
    const dText      = document.getElementById('dir-text');
    const dCoords    = document.getElementById('dir-coords');
    const dRoute     = document.getElementById('dir-route');
    const dLiveBtn   = document.getElementById('dir-live-btn');
    const dMapBtn    = document.getElementById('dir-map-btn');
    const dMapFrame  = document.getElementById('dir-map-iframe');
    const dCloseBtn  = document.getElementById('dir-close');
    const requestedRoom = <?= json_encode($initial_room) ?>;

    function formatCoordinate(value, positiveLabel, negativeLabel) {
        const num = Number(value);
        if (!Number.isFinite(num)) return value;
        const direction = num >= 0 ? positiveLabel : negativeLabel;
        return Math.abs(num).toFixed(6) + '° ' + direction;
    }

    let userOrigin = null;
    let pendingDestination = null;

    function applyRouteLink(destinationCoord) {
        if (userOrigin) {
            dLiveBtn.href = 'https://www.google.com/maps/dir/?api=1'
                          + '&origin=' + encodeURIComponent(userOrigin)
                          + '&destination=' + encodeURIComponent(destinationCoord)
                          + '&travelmode=walking';
            dRoute.innerHTML = '<strong>Route:</strong> Your Location -> Destination';
        } else {
            dLiveBtn.href = 'https://www.google.com/maps/dir/?api=1'
                          + '&destination=' + encodeURIComponent(destinationCoord)
                          + '&travelmode=walking';
            dRoute.innerHTML = '<strong>Route:</strong> Source will be auto-detected in Google Maps';
        }
    }

    if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                userOrigin = position.coords.latitude + ',' + position.coords.longitude;
                if (pendingDestination) {
                    applyRouteLink(pendingDestination);
                }
            },
            function () {
                userOrigin = null;
                if (pendingDestination) {
                    applyRouteLink(pendingDestination);
                }
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 300000 }
        );
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const name = btn.dataset.name;
            const lat  = btn.dataset.lat;
            const lng  = btn.dataset.lng;
            const coord = lat + ',' + lng;
            pendingDestination = coord;

            // Textual info
            dTitle.textContent  = '📍 ' + name;
            dFloor.textContent  = 'Located on: ' + btn.dataset.floor;
            dText.textContent   = btn.dataset.direction;
            dCoords.innerHTML   = '<strong>Coordinates:</strong> '
                                + formatCoordinate(lat, 'N', 'S')
                                + ', '
                                + formatCoordinate(lng, 'E', 'W');

            // Embedded live map (marker on selected room)
            dMapFrame.src = 'https://www.google.com/maps?q=' + coord + '&z=19&output=embed';

            // Live direction with auto source when GPS permission is granted
            applyRouteLink(coord);

            // View location on Google Maps
            dMapBtn.href  = 'https://www.google.com/maps?q=' + coord;

            display.style.display = 'block';
            display.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    if (requestedRoom) {
        const preselect = Array.from(buttons).find(
            b => b.dataset.name.toLowerCase() === requestedRoom.toLowerCase()
        );
        if (preselect) preselect.click();
    }

    dCloseBtn.addEventListener('click', () => {
        display.style.display = 'none';
        buttons.forEach(b => b.classList.remove('active'));
    });
});
</script>

<?php require_once '../includes/student_footer.php'; ?>

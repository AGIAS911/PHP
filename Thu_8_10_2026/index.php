<?php

$errors = [];

$name = "";
$email = "";
$mobile = "";
$governorate = "";
$track = "";
$skills = [];
$message = "";
$agree = "";

$registration = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $mobile = trim($_POST["mobile"] ?? "");
    $governorate = trim($_POST["governorate"] ?? "");
    $track = trim($_POST["track"] ?? "");
    $message = trim($_POST["message"] ?? "");
    $agree = $_POST["agree"] ?? "";

    $submittedSkills = $_POST["skills"] ?? [];

    if (is_array($submittedSkills)) {
        $allowedSkills = ["HTML", "CSS", "JavaScript"];

        $skills = array_values(
            array_intersect($submittedSkills, $allowedSkills)
        );
    }

    if ($name === "") {
        $errors["name"] = "Full name is required.";
    }

    if ($email === "") {
        $errors["email"] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please enter a valid email.";
    }

    // Validate Mobile
    if ($mobile === "") {
        $errors["mobile"] = "Mobile is required.";
    } elseif (!preg_match("/^07[789][0-9]{7}$/", $mobile)) {
        $errors["mobile"] = "Enter a valid Jordanian mobile number.";
    }

    // Validate Governorate
    $allowedGovernorates = ["Amman", "Irbid", "Aqaba", "Zarqa"];

    if (!in_array($governorate, $allowedGovernorates, true)) {
        $errors["governorate"] = "Please select a valid governorate.";
    }

    // Validate Track
    $allowedTracks = ["Full Stack", "Frontend", "Backend"];

    if (!in_array($track, $allowedTracks, true)) {
        $errors["track"] = "Please select a valid track.";
    }

    // Validate Skills
    if (empty($skills)) {
        $errors["skills"] = "Please select at least one skill.";
    }

    // Validate Terms
    if ($agree !== "on") {
        $errors["agree"] = "You must accept the academy terms.";
    }

    // Create registration object if there are no errors
    if (empty($errors)) {

        $registration = new stdClass();

        $registration->name = $name;
        $registration->email = $email;
        $registration->mobile = $mobile;
        $registration->governorate = $governorate;
        $registration->track = $track;
        $registration->skills = $skills;
        $registration->message = $message;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academy Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body data-posted="<?= $_SERVER["REQUEST_METHOD"] === "POST" ? "true" : "false" ?>">

    <form id="registrationForm" action="" method="post">

        <h1>Academy Registration</h1>

        <label for="name">Full Name</label>
        <input
            type="text"
            id="name"
            name="name"
            value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">

        <?php if (isset($errors["name"])): ?>
            <span class="error">
                <?= htmlspecialchars($errors["name"], ENT_QUOTES, 'UTF-8') ?>
            </span>
        <?php endif; ?>


        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">

        <?php if (isset($errors["email"])): ?>
            <span class="error">
                <?= htmlspecialchars($errors["email"], ENT_QUOTES, 'UTF-8') ?>
            </span>
        <?php endif; ?>


        <label for="mobile">Mobile</label>
        <input
            type="tel"
            id="mobile"
            name="mobile"
            placeholder="0791234567"
            value="<?= htmlspecialchars($mobile, ENT_QUOTES, 'UTF-8') ?>">

        <?php if (isset($errors["mobile"])): ?>
            <span class="error">
                <?= htmlspecialchars($errors["mobile"], ENT_QUOTES, 'UTF-8') ?>
            </span>
        <?php endif; ?>


        <label for="governorate">Governorate</label>
        <select id="governorate" name="governorate">

            <option value="">Choose a governorate</option>

            <?php foreach (["Amman", "Irbid", "Aqaba", "Zarqa"] as $city): ?>
                <option
                    value="<?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8') ?>"
                    <?= $governorate === $city ? "selected" : "" ?>>
                    <?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>

        </select>

        <?php if (isset($errors["governorate"])): ?>
            <span class="error">
                <?= htmlspecialchars($errors["governorate"], ENT_QUOTES, 'UTF-8') ?>
            </span>
        <?php endif; ?>


        <label>Track</label>

        <?php foreach (["Full Stack", "Frontend", "Backend"] as $option): ?>
            <label class="inline">
                <input
                    type="radio"
                    name="track"
                    value="<?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?>"
                    <?= $track === $option ? "checked" : "" ?>>
                <?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?>
            </label>
        <?php endforeach; ?>

        <?php if (isset($errors["track"])): ?>
            <span class="error">
                <?= htmlspecialchars($errors["track"], ENT_QUOTES, 'UTF-8') ?>
            </span>
        <?php endif; ?>


        <label>Skills you already have</label>

        <?php foreach (["HTML", "CSS", "JavaScript"] as $skill): ?>
            <label class="inline">
                <input
                    type="checkbox"
                    name="skills[]"
                    value="<?= htmlspecialchars($skill, ENT_QUOTES, 'UTF-8') ?>"
                    <?= in_array($skill, $skills, true) ? "checked" : "" ?>>
                <?= htmlspecialchars($skill, ENT_QUOTES, 'UTF-8') ?>
            </label>
        <?php endforeach; ?>

        <?php if (isset($errors["skills"])): ?>
            <span class="error">
                <?= htmlspecialchars($errors["skills"], ENT_QUOTES, 'UTF-8') ?>
            </span>
        <?php endif; ?>


        <label for="message">Why do you want to join? (optional)</label>
        <textarea
            id="message"
            name="message"
            rows="4"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></textarea>


        <label class="inline terms">
            <input
                type="checkbox"
                name="agree"
                <?= $agree === "on" ? "checked" : "" ?>>
            I agree to the academy terms
        </label>

        <?php if (isset($errors["agree"])): ?>
            <span class="error">
                <?= htmlspecialchars($errors["agree"], ENT_QUOTES, 'UTF-8') ?>
            </span>
        <?php endif; ?>


        <button type="submit">Register</button>

    </form>


    <section id="registrationResult" class="registration-result"></section>

    <?php if ($registration !== null): ?>
        <script type="application/json" id="registrationData"><?=
            json_encode(
                $registration,
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
            )
        ?></script>
    <?php endif; ?>

    <script src="script.js"></script>

</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $videoUrl = $_POST['video-url'];
    $format = $_POST['quality'];

    if (empty($videoUrl)) {
        die("Erreur : Veuillez entrer une URL valide.");
    }

    $outputFormat = $format == "mp3" ? "mp3" : "mp4";
    $outputFile = "downloads/video.%($outputFormat)s";

    // Vérification du dossier de téléchargement
    if (!is_dir("downloads")) {
        mkdir("downloads", 0777, true);
    }

    // Commande yt-dlp pour télécharger la vidéo
    $command = escapeshellcmd("yt-dlp -f best -x --audio-format {$outputFormat} -o '{$outputFile}' '{$videoUrl}'");
    
    // Exécuter la commande
    exec($command, $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "Téléchargement terminé. <a href='downloads/video.{$outputFormat}' download>Cliquez ici pour télécharger</a>";
    } else {
        echo "Erreur lors du téléchargement. Vérifiez l'URL et réessayez.";
    }
} else {
    echo "Accès non autorisé.";
}
?>

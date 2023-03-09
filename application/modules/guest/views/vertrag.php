<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Mietvertrag</title>
  </head>
  <body>
  <div>  
  <table  border="0px solid black" cellpadding="0px" cellspacing="0px" style="width:100%">
    <tr>
    <th>Mietvertrag</th>
    </tr>
    <tr>
    <td>
        <table>
            <tr>
                <td><b>Vermieter:</b> <u><?php echo $vermieter; ?></u></td>
            </tr>
            <tr>
                <td><b>Mieter:<u></b><?php echo $mieter; ?></u></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr><td><b>§1  Mieträume</b><br>
        Der Vermieter vermietet dem Mieter  zu <u><?php echo $wohnzweck; ?></u> die im Hause: <u><?php echo $adresse; ?></u> 
        Die Wohnfläche beträgt <u><?php echo $wohnfleche; ?></u>qm, vermietet wird: <u><?php echo $raumlichkeiten; ?></u>
    </td>
  </tr>
  <tr><td><b>§2  Mietzins und Nebenkosten</b><br>
        Miete und Nebenkosten sind ab Beginn der Mietzeit monatlich im Voraus zu bezahlen.
        Die monatliche Grundmiete beträgt: <u><?php echo $kaltmiete; ?> €</u>
        Nebenkosten Pauschal: <u><?php echo $nebenkosten; ?> €</u> (Siehe Nebenkostentabelle)
        Insgesamt sind vom Mieter monatlich: <u><?php echo $kaltmiete+$nebenkosten; ?> €</u> auf das Konto mit der IBAN: <u><?php echo $iban; ?></u> zu bezahlen.
      </td>
  </tr>
  <tr><td><b>§3  Mietsicherheit/Kaution</b><br>
        Der Mieter hat bei Beginn des Mietverhältnisses eine Mietsicherheit in Höhe von EUR <u><?php echo $kaution; ?> <?php echo $kautionart; ?></u> zuleistet. Ist die Kaution innerhalb von 2 Monaten nicht bezahlt, liegt eine Vertragsverletzung vor, die automatisch zu einer fristlosen kündigung führt.
      </td></tr>
  <tr><td><b>§4  Mietdauer und Kündigung</b><br>
  Das Mietverhältnis beginnt am: <u><?php echo $begin; ?></u> und läuft am <u><?php echo $ende; ?></u>  ab.
  Eine Kündigung hat schriftlich zu erfolgen.
  Setzt der Mieter den Gebrauch der Mietsache fort, so gilt das Mietverhältnis nicht als verlängert.</td></tr>
  <tr><td><b>§5  Selbstbeteiligung bei Schäden/Kleinreparaturen</b><br>
  Selbstbeteiligung bei  Kleinreparaturen wie (Installationen, Einrichtungen für Wasser, Strom, Gas, Heiz- und
  Kocheinrichtungen sowie Rollläden, Jalousien, Fensterläden und Markisen, Steckdosen, Fenster und Türverschlüsse.) beträgt <u><?php echo $selbstbeteiligung; ?></u>,-EUR inkl. MwSt. im Jahr</td></tr>
  <tr><td><b>§6  Zustand der Mieträume</b><br>
  Der Vermieter gewährt dem Mieter den Gebrauch der Mietsache in dem Zustand bei Übergabe. Dieser Zustand ist dem Vermieter bei Übergabe der Mietsache bekannt und wird in einem Protokoll festgehalten, welches wesentlicher Bestandteil des Mietvertrages ist.
  Zu Beginn des Mietverhältnisses werden bekannte Mängel an der Mietsache werden vom Mieter als vertragsgemäß anerkannt. Eine verschuldensunabhängige Haftung des Vermieters für anfängliche Mängel wird ausgeschlossen.
  Sollten noch Restarbeiten an der Mietsache durch den Vermieter durchgeführt sein, so kann die Übergabe der Mietsache an den Mieter nicht verweigert werden, sofern die Nutzung als Wohnung nur unerheblich beeinträchtigt ist.</td></tr>
  <tr><td><b>§7  Instandhaltung der Mietsache</b><br>
  1. Der Mieter ist verpflichtet, die Mietsache und die gemeinschaftlichen Einrichtungen und Anlagen pfleglich und schonend zu behandeln.
  Schäden am Haus und in den Mieträumen sind dem Vermieter unverzüglich anzuzeigen. Für durch verspätete Anzeige verursachte Schäden haftet der Mieter.
  2. Der Mieter hat für ordnungsgemäße Reinigung der Mieträume sowie deren ausreichende Beheizung und Belüftung sowie Schutz der Innenräume vor Frost zu sorgen.
  Der Mieter haftet dem Vermieter für Schäden, die durch die Verletzung seiner ihm obliegenden Obhuts-, Sorgfalts- und Anzeigepflicht schuldhaft verursacht werden. Er haftet in gleicher Weise für Schäden, die durch seine Angehörigen, Untermieter, Arbeiter, Angestellten, Handwerker und Personen, die sich mit seinem Willen in der Wohnung aufhalten oder ihn aufsuchen, verursacht werden.
  Hat der Mieter oder der vorgenannte Personenkreis einen Schaden an der Mietsache verursacht, so hat er diesen unverzüglich dem Vermieter anzuzeigen.
  Der Mieter hat Schäden, für die er einstehen muss, unverzüglich zu beseitigen. Kommt er dieser Verpflichtung auch nach schriftlicher Mahnung innerhalb einer angemessenen Frist nicht nach, so kann der Vermieter die erforderlichen Arbeiten auf Kosten des Mieters vornehmen lassen.
  Der Mieter hat zu beweisen, dass ein Verschulden seinerseits nicht vorgelegen hat.</td></tr>
  <tr><td><b>§8  Benutzung der Mietsache</b><br>
  1. Der Mieter darf die angemieteten Räume zu anderen als zu Wohnzwecken nur mit Erlaubnis des Vermieters benutzen.
  Eine Zustimmung des Vermieters ist ebenfalls schriftlich erforderlich, wenn der Mieter an der Mietsache Um-, An-, und Einbauten, Installationen oder andere Veränderungen vornehmen will.
  2. Die Parteien sind sich darüber einig, dass eine Untervermietung oder die Überlassung der Mietsache an Dritte der Zustimmung des Vermieters bedarf. 3. Die Haltung von Kleintieren ist dem Mieter ohne Zustimmung des Vermieters gestattet, soweit durch die Unterbringung in den Mieträumen eine Beeinträchtigung der Mietsache oder eine Belästigung von Hausbewohnern oder Nachbarn nicht gegeben ist. Die Haltung von Hunden und Katzen sowie anderer Tiere bedarf der Zustimmung des Vermieters.</td></tr>
  <tr><td><b>§9  Beendigung des Mietverhältnisses</b><br>
  1. Rückgabe der Mietsache
  Der Mieter hat dem Vermieter die Mietsache vollständig geräumt und gereinigt und mit sämtlichen, auch den vom Mieter beschafften, Schlüssel zu einem von beiden Parteien vereinbarten Termin zu übergeben. Über die Übergabe ist ein Protokoll zu erstellen.</td></tr>
  <tr><td><b>§10 Protokoll Messgeräte</b><br>
  Der Mieter hat dafür Sorge zu tragen, dass bei allen in der Mietsache befindlichen Messgeräte  (Heizung, Warm-, Kaltwasser etc.) auf seine Kosten eine Zwischenablesung stattfindet. Das Protokoll über die Zwischenablesung ist dem Vermieter spätestens jede 6 Monate auszuhändigen, andernfalls hat der Vermieter das Recht, eine grobe Schätzung des Verbrauches zu machen.</td></tr>
  </table>
  <br>
  <table border="0px solid black" cellpadding="1px" cellspacing="1px" style="width:100%">
      <tr><td><b>Nebenkostentabelle:</b>
      <br><b>Grundsteuer:</b><br>
  Wird von der jeweiligen Kommune erhoben, teilweise stehen in Mietverträgen auch "öffentliche Lasten des Grundstücks".
  <br><b>Heizung:</b><br>
  Ölkosten für die Heizung.
  <br><b>Warmwasser:</b><br>
  Kosten der Warmwasserbereitung. (Küche,Bad etc.)
  <br><b>Abwasser:</b><br>
  Das sind Gebühren für die Nutzung einer öffentlichen Entwässerungsanlage oder die Kosten der Abfuhr und Reinigung einer eigenen Klär- oder Sickergrube.  
  <br><b>Straßenreinigung/Müllabfuhr:</b><br>
  Kosten, die die Stadt dem Vermieter durch Abgabenbescheid in Rechnung stellt.
  <br><b>Gartenpflege:</b><br>
  Sach- und Personalkosten, die durch die Pflege der hauseigenen Grünanlage entstehen. Kosten für die Erneuerung von Pflanzen oder für die Pflege von Spielplätzen zählen mit.
  <br><b>Schornsteinreinigung:</b><br>
  Schornsteinfegerkosten (Kehrgebühren) und Kosten der Immissionsmessung.  
  <br><b>Hauswart:</b><br>
  Personalkosten für den Hausmeister, der zum Beispiel Gartenpflege, Schneebeseitigung, Treppenhausreinigung usw. übernimmt.
  <br></td><td><b>Einrichtung Wäschepflege:</b><br>
  Kosten für die Waschküche, zum Beispiel auch für die Gemeinschafts Waschmaschinen oder Trockner, das heißt Strom, Reinigung und Wartung der Geräte.
  <br><b>Wasserkosten:</b><br>
  Hierzu zählen das Wassergeld, die Kosten der Wasseruhr und zum Beispiel auch die Kosten für eine Wasseraufbereitungsanlage.
  <br><b>Fahrstuhl:</b><br>
  Das sind Kosten des Betriebsstroms, der Beaufsichtigung, Bedienung, Überwachung, Pflege und Reinigung sowie regelmäßige Prüfung der Betriebssicherheit und Betriebsbereitschaft.
  <br><b>Hausreinigung/Ungezieferbekämpfung:</b> <br>
  Kosten, zum Beispiel für eine Putzfrau, die die Flure, Treppen, Keller, Waschküche usw. reinigt. Kosten der Ungezieferbekämpfung sind nur die laufenden Kosten, zum Beispiel Kosten für ein Insektenspray.
  <br><b>Beleuchtung:</b><br>
  Stromkosten für Außenbeleuchtung, Treppenhaus, Waschküche.
  <br><b>Versicherungen:</b><br>
  Gebäudeversicherungen gegen Feuer-, Sturm- und Wasserschäden, Glasversicherungen sowie Haftpflichtversicherungen für Gebäude, Öltank und Aufzug.
  <br><b>Gemeinschaftsantenne/Breitbandkabel:</b><br>
  Bei der Antenne können Betriebs-, Strom- und Wartungskosten auf die Mieter umgelegt werden. Beim Kabel kommt noch die monatliche, an die Telekom oder Kabel-Service-Gesellschaft zu zahlende Grundgebühr hinzu. Anders, wenn der Mieter einen Vertrag direkt mit der Telekom oder einer privaten Kabel-Service-Gesellschaft geschlossen hat.</td></tr>
  </table>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>

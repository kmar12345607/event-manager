<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background:#f8fafc; padding:24px; margin:0;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table role="presentation" width="480" cellpadding="0" cellspacing="0"
                       style="background:#ffffff; border-radius:14px; overflow:hidden; border:1px solid #e2e8f0;">
                    <tr>
                        <td style="background:#1a2744; padding:24px 28px;">
                            <span style="color:#ffffff; font-size:18px; font-weight:700;">
                                ✅ Entrée validée
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <p style="font-size:16px; color:#1e293b; margin:0 0 12px;">
                                Bonjour {{ $participant->full_name }},
                            </p>
                            <p style="font-size:14px; color:#475569; line-height:1.6; margin:0 0 20px;">
                                Ton billet pour <strong>{{ $participant->event->name }}</strong> vient d'être scanné avec succès à l'entrée.
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                   style="background:#f1f5f9; border-radius:10px; padding:16px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:14px 18px; font-size:13px; color:#475569;">
                                        <strong>Événement :</strong> {{ $participant->event->name }}<br>
                                        <strong>Lieu :</strong> {{ $participant->event->location ?? '—' }}<br>
                                        <strong>Heure d'entrée :</strong> {{ $participant->checked_in_at->format('H:i') }} le {{ $participant->checked_in_at->format('d/m/Y') }}<br>
                                        <strong>Code billet :</strong> {{ $participant->ticket_code }}
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size:13px; color:#94a3b8; margin:0;">
                                Bonne participation ! — L'équipe Event Manager
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
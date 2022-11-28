SELECT 
    m.nama,
    (
        SELECT 
            JSON_ARRAYAGG(JSON_OBJECT(
                'nama', jp.nama,
                'pakaian', (
                    SELECT 
                        JSON_ARRAYAGG(JSON_OBJECT(
                            'nama', p.nama,
                            'warna', (
                                SELECT 
                                    JSON_ARRAYAGG(JSON_OBJECT(
                                        'warna', w.nama,
                                        'ukuran', (
                                            SELECT 
                                                JSON_ARRAYAGG(JSON_OBJECT(
                                                    'ukuran', u.nama,
                                                    'jumlah', (SELECT SUM(jumlah) FROM pakaian_disuplai AS pd WHERE pd.id_ukuran_warna_pakaian=uwp.id)
                                                )) 
                                            FROM 
                                                ukuran_warna_pakaian AS uwp 
                                            INNER JOIN 
                                                ukuran AS u 
                                            ON 
                                                u.id=uwp.id_ukuran 
                                            WHERE 
                                                uwp.id_warna_pakaian=wp.id
                                        )
                                    )) 
                                FROM 
                                    warna_pakaian AS wp 
                                INNER JOIN 
                                    warna AS w 
                                ON 
                                    w.id=wp.id_warna 
                                WHERE 
                                    wp.id_pakaian=p.id
                            )
                        )) 
                    FROM 
                        pakaian AS p 
                    WHERE 
                        p.id_merk=m.id AND p.id_jenis_pakaian=jp.id
                )
            ))
        FROM 
            jenis_pakaian AS jp  
    ) AS jenis_pakaian
FROM 
    merk AS m

SELECT 
    u.nama
FROM 
    ukuran_warna_pakaian AS uwp 
INNER JOIN 
    ukuran AS u 
ON 
    u.id=uwp.id_ukuran 
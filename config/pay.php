<?php
    return [
        'alipay' => [
            'app_id'         => '2016100100640578',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiu9MaMnZ9iuGTvApc4MxZfs3uQJbZ5iMPUNIARgicKY9Y35vovHAdD/3ab0ZX7WCmh5dprBDAcLs0nCnydrjCotJ82viD4aAa7fTvKYuGgPhirC8skATtv6NoeCc1lD/XczpAQtjTC0qhTUeu+u9daUOmFie66JYzTGzFMfRw/VNd8/E4Kn7VjcFsyUf20ms0m18lYYaWQEyVUTOlMmrLX/Z7pPMTctsPYdY4/Y8TRhtSJ1sVZxcnqVhgXd4cGhPjVj9dFm0S5VbC16CcKqZhNJBxYdf5VyoYasB2q27WH2YqATLulz9GATuMQXU5moXYXe3S1vQQY749MAM4SYcNQIDAQAB',
            'private_key'    => 'MIIEowIBAAKCAQEA230EZdmT1462IAIS1Q+DGf6taH98F+Uii0RFc0l84/NwsrPChEyT0qq++XWnc58HH3dw+PFmzHTqTd6LcQHMl/OiHkuJMCo4ehnbgsiCMEH64wB6u4AiuwSDV1aoroZPaJUnvIMhVSkaLPqmJU+2Vvyrp9lIkE5bAVin51XrQaOCIB0HTwOPdTZvYUsG12JjOmJBg0Yq6owvfEel6fwUJAs99vRH+qDY/F9wRV2Kp2smw/RYc0TOtAq3yYeb+PWHKtkhdv3LoTXzToB5za+T8WZTEJSojU9Wn6JxubVZnANkbvh5ohBfj7UF9Ws68s44czDxuW10Le/lHu36MrcWYQIDAQABAoIBAQDGzRWOquQd+kU7+KTWFpbIlMS8QbxEaGZBfjTpl0ZnsbgCJI+rBTFfPwh7KvXg48mv1p+c3AogZkVTAp+KW/bUKvhMOF6qIZPGBGWur647x4dW1LhV3FmYyx2rnfJrIXwLXg3/0UX/vJrY4q5aXTjq0TEpdsUi79W+Am8SOeA8Mg+RliNXMwUhIKv+OqgKSnakpy573J/N4x4HV9ZYuhg+Wcz42hNl2OVebrGhvQeB/NHTyIA59Xfj82ReWnaeK5MnsGXMgLdfJ+fEloI0VsqZNPxQYosWtoGYLVY1c4xT0o07AKTnUh1cVmGGnfiykUIVlSgca8kTAHme4fIdjS2BAoGBAPZPWV8EdfTK34T4wsB21kzmZzvTd0Q5Dav2T//rpOI79Rj3dgblpnYHnpkSGMq0stVWzsj5/z1vdxLW5ew5Oihq5fRwfiAs5OA6BTAba9l+Ra9heORXF5EU/tuOvFsgjP6XkH+mbq8EiBbGYrmDNqmEfkwKbgSoja+yc9eMn5CLAoGBAOQfim7SzlgyqfA1lGRw49rIVBdWm9ubieq0y38kf0gFILjb/tKKOslkuiWnizsNnMUA1kJRbsELztARIsTlQopqGGERGNbJ4hadQJs187CVFCBHm/40AL2cp0AtsM9ArVHFrn9mWTdzWnw8+VP192INGMf4m1unSrF+TIUv0wZDAoGAAKpMMn5/lw6pNeG6HOz1PTXuF3JFwzBoQgujQaywQFArJEsezXv3TCBPJFixKnL8fKkEW/SY5OCVML7V1iJ9briDMHrRTGLyp0xg0TVxwB+gLo4T1oIJtUGaQpuLFK/s0Y81O7MGX4CioXUdtSSOlDygXrI0g9y0rUHNIErn72sCgYBwP/TmQ2S1kXh9cl/qbIIyDZETStK2ZPqgOwZHMbZPwfYwAFCLWOlEYAQYszCXhkM1zQug5mERLLY/O69YI1dytHH6kWcfiYduiUJZHVsj8LdOiu3/T6dtpb/GnLT7xl+CdTtABSSxXFmR+I7W+ZkY7kjbXUFVACSI4hTVFItJ8QKBgGxH6rDo/Q6PbOkhq/Kl/G04UNQ1YdshP9NE388Gof18yQPMWvj9twfkxaGNt0tJLG+7kxGhJ2fg5np9saDZkT1MFz5ikIXib2XR0uTIuUZwpJUIRpI4s4MV4lFIokBWrjsFQcu1iFRNArRVD/VLtkhZjVflHukf8IuKQF6urfTq',
            'log'            => [
                'file' => storage_path('logs/alipay.log'),
            ],
        ],

        'wechat' => [
            'app_id'      => '',
            'mch_id'      => '',
            'key'         => '',
            'cert_client' => '',
            'cert_key'    => '',
            'log'         => [
                'file' => storage_path('logs/wechat_pay.log'),
            ],
        ],
    ];
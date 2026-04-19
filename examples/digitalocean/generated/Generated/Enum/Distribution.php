<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum Distribution: string
{
    case ArchLinux = 'Arch Linux';
    case CentOs = 'CentOS';
    case CoreOs = 'CoreOS';
    case Debian = 'Debian';
    case Fedora = 'Fedora';
    case FedoraAtomic = 'Fedora Atomic';
    case FreeBsd = 'FreeBSD';
    case Gentoo = 'Gentoo';
    case OpenSuse = 'openSUSE';
    case RancherOs = 'RancherOS';
    case RockyLinux = 'Rocky Linux';
    case Ubuntu = 'Ubuntu';
    case Unknown = 'Unknown';
}

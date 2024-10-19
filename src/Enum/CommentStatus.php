<?php

namespace App\Enum;

enum CommentStatus: string
{
    case Pending = 'pending';
    case Published = 'published';
    case Moderated = 'moderated';
    
    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'En cours',
            self::Published => 'Publié',
            self::Moderated => 'Modéré',
        };
    }
}
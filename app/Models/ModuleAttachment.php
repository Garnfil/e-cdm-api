<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleAttachment extends Model
{
    use HasFactory;

    protected $table = 'module_attachments';

    protected $fillable = [
        'module_id',
        'attachment_name',
        'attachment_type',
        'status',
    ];

    const ATTACHMENT_TYPE_FILE = 'file';

    const ATTACHMENT_TYPE_LINK = 'link';

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}

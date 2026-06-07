<style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:var(--font-sans);color:var(--color-text-primary)}
    .dash{padding:1.5rem 0;display:flex;flex-direction:column;gap:1.5rem}
    .section-title{font-size:13px;font-weight:500;color:var(--color-text-secondary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem}
    .card{background:var(--color-background-primary);border:0.5px solid var(--color-border-tertiary);border-radius:var(--border-radius-lg);padding:1.25rem}
    .profile-card{display:flex;align-items:center;gap:1rem;flex-wrap:wrap}
    .avatar-wrap{position:relative;flex-shrink:0}
    .avatar{width:72px;height:72px;border-radius:50%;background:var(--color-background-info);display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:500;color:var(--color-text-info);overflow:hidden}
    .avatar img{width:100%;height:100%;object-fit:cover}
    .avatar-edit{position:absolute;bottom:0;right:0;width:24px;height:24px;background:var(--color-background-primary);border:0.5px solid var(--color-border-secondary);border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer}
    .avatar-edit i{font-size:13px;color:var(--color-text-secondary)}
    .profile-info{flex:1;min-width:180px}
    .profile-name{font-size:18px;font-weight:500;margin-bottom:4px}
    .profile-meta{display:flex;align-items:center;gap:.5rem;margin-bottom:4px}
    .badge{display:inline-block;font-size:11px;font-weight:500;padding:2px 8px;border-radius:var(--border-radius-md)}
    .badge-admin{background:#EAF3DE;color:#3B6D11}
    .badge-user{background:#E6F1FB;color:#185FA5}
    .badge-editor{background:#FAEEDA;color:#854F0B}
    .profile-email{font-size:13px;color:var(--color-text-secondary)}
    .profile-actions{display:flex;gap:.5rem;margin-left:auto}
    .btn{display:inline-flex;align-items:center;gap:6px;font-size:13px;padding:6px 14px;border-radius:var(--border-radius-md);border:0.5px solid var(--color-border-secondary);background:transparent;cursor:pointer;color:var(--color-text-primary);transition:background .15s}
    .btn:hover{background:var(--color-background-secondary)}
    .btn-primary{background:var(--color-text-primary);color:var(--color-background-primary);border-color:transparent}
    .btn-primary:hover{opacity:.85}
    .divider{border:none;border-top:0.5px solid var(--color-border-tertiary);margin:.25rem 0}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
    .form-group{display:flex;flex-direction:column;gap:6px}
    .form-group label{font-size:12px;color:var(--color-text-secondary)}
    .form-group input,
    .form-group select{padding:8px 10px;border-radius:var(--border-radius-md);border:0.5px solid var(--color-border-secondary);background:var(--color-background-secondary);color:var(--color-text-primary);font-size:14px;font-family:inherit}
    .form-group input:focus,.form-group select:focus{outline:none;border-color:var(--color-border-primary)}
    .pw-section{display:flex;flex-direction:column;gap:1rem}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px}
    .stat-card{background:var(--color-background-secondary);border-radius:var(--border-radius-md);padding:1rem}
    .stat-label{font-size:12px;color:var(--color-text-secondary);margin-bottom:6px}
    .stat-value{font-size:24px;font-weight:500}
    .stat-sub{font-size:12px;color:var(--color-text-secondary);margin-top:4px}
    .stat-up{color:#3B6D11}
    .stat-down{color:#A32D2D}
    .users-table{width:100%;border-collapse:collapse;font-size:13px}
    .users-table th{text-align:left;font-size:11px;font-weight:500;color:var(--color-text-secondary);padding:6px 8px;border-bottom:0.5px solid var(--color-border-tertiary)}
    .users-table td{padding:8px;border-bottom:0.5px solid var(--color-border-tertiary)}
    .users-table tr:last-child td{border-bottom:none}
    .users-table select{font-size:12px;padding:3px 6px;border:0.5px solid var(--color-border-secondary);border-radius:var(--border-radius-md);background:var(--color-background-secondary);color:var(--color-text-primary)}
    .user-cell{display:flex;align-items:center;gap:8px}
    .mini-avatar{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:500;background:var(--color-background-info);color:var(--color-text-info);flex-shrink:0}
    .form-actions{display:flex;justify-content:flex-end;gap:.5rem;margin-top:.5rem}
    .upload-hint{font-size:11px;color:var(--color-text-secondary);margin-top:4px}
</style>
<div>
    <div class="section-title">تغییر رمز عبور</div>
    <div class="card">
        <div class="pw-section">
            <div class="form-group">
                <label>رمز عبور فعلی</label>
                <input type="password" placeholder="••••••••">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>رمز عبور جدید</label>
                    <input type="password" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label>تکرار رمز عبور جدید</label>
                    <input type="password" placeholder="••••••••">
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary"><i class="ti ti-lock" aria-hidden="true"></i> تغییر رمز</button>
        </div>
    </div>
</div>

<style>

/* CARD */

.sidebar-card,
.profile-card{

    border:none;

    border-radius:24px;

    box-shadow:0 10px 30px rgba(0,0,0,.06);

}

/* PROFILE AVATAR */

.profile-avatar{

    width:65px;

    height:65px;

    border-radius:50%;

    background:#2563eb;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:24px;

    font-weight:bold;

}

/* MENU */

.menu-profile{

    display:flex;

    flex-direction:column;

    gap:10px;

}

.menu-item{

    text-decoration:none;

    color:#4b5563;

    padding:12px 16px;

    border-radius:14px;

    font-weight:500;

    transition:.3s;

}

.menu-item i{

    margin-right:10px;

}

.menu-item:hover{

    background:#eff6ff;

    color:#2563eb;

}

.menu-item.active{

    background:#2563eb;

    color:white;

}

/* INPUT */

.profile-input{

    border-radius:14px;

    border:1px solid #e5e7eb;

    padding:12px 16px;

}

.profile-input:focus{

    border-color:#2563eb;

    box-shadow:0 0 0 4px rgba(37,99,235,.12);

}

/* BUTTON */

.btn-save{

    background:#2563eb;

    color:white;

    border:none;

    border-radius:50px;

    padding:12px 35px;

    font-weight:600;

    transition:.3s;

}

.btn-save:hover{

    background:#1d4ed8;

    color:white;

    transform:translateY(-2px);

}

/* FOTO */

.photo-section{

    border-left:1px solid #e5e7eb;

    padding-left:30px;

}

.profile-photo{

    width:150px;

    height:150px;

    border-radius:50%;

    object-fit:cover;

    border:5px solid #eff6ff;

    transition:.3s;

}

.profile-photo:hover{

    transform:scale(1.05);

}

/* VERIFIED BADGE */

.verified-badge{

    color:#16a34a;

    font-size:14px;

    font-weight:600;

    white-space:nowrap;

}

/* MOBILE */

@media(max-width:992px){

    .photo-section{

        border:none;

        padding-left:0;

        margin-top:30px;

    }

}

</style>
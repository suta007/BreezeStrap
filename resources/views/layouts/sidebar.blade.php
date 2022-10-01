<div class="sidebar col bg-white p-2 shadow-md" id="sidebar">
	<a href="/" class="d-flex align-items-center mb-md-0 me-md-auto text-decoration-none text-web ms-3 mb-3">
		<img src="{{ asset('images/logo.png') }}" style="height: 48px;">
		<span class="ms-3 fs-5 fw-bold">{{ config('app.name', 'Laravel') }}</span>
	</a>
	<hr>
	<div class="fw-bold ps-2 text-web">
		<i class="fa-solid fa-user me-2"></i>{{ Auth::user()->name }}<br>
		<i class="fa-solid fa-award me-2"></i>เกียรติบัตรของ {{ Auth::user()->org->name }}
	</div>
	<hr>
	<ul class="list-unstyled ps-0">
		<li>
			<a class="navlink ps-4 mb-1 rounded py-2" href="{{ route('user.main.edit') }}"><i class="fa-solid fa-user me-2"></i>แก้ไขข้อมูลส่วนตัว</a>
		</li>
		<li>
			<a class="navlink ps-4 mb-1 rounded py-2" href="{{ route('user.main.editpass') }}"><i class="fa-solid fa-key me-2"></i>เปลี่ยนรหัสผ่าน</a>
		</li>
		<li>
			<a class="navlink ps-4 mb-1 rounded py-2" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="fa-solid fa-right-to-bracket me-2"></i>ออกจากระบบ</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
				@csrf
			</form>
		</li>
		@if (Role('user'))
			<hr>
			<li>
				<a class="navlink ps-4 mb-1 rounded py-2" href="{{ route('user.certificate.index') }}"><i class="fa-solid fa-list me-2"></i>รายการเกียรติบัตร</a>
			</li>
			<li>
				<a class="navlink ps-4 mb-1 rounded py-2" href="{{ route('user.certificate.create', 1) }}"><i class="fa-solid fa-award me-2"></i>สร้างเกียรติบัตร</a>
			</li>
			<li>
				<a class="navlink ps-4 mb-1 rounded py-2" href="{{ route('user.setting.index') }}"><i class="fa-solid fa-gear me-2"></i>ตั้งค่ารูปแบบเกียรติบัตร</a>
			</li>
		@endif
		@if (Role('admin'))
			<hr>
			<li>
				<a class="navlink ps-4 mb-1 rounded py-2" href="{{ route('admin.user.index') }}"><i class="fa-solid fa-user-gear me-2"></i>ผู้ใช้งานงานระบบ</a>
			</li>
			<li>
				<a class="navlink ps-4 mb-1 rounded py-2" href="{{ route('admin.org.index') }}"><i class="fa-solid fa-school-flag me-2"></i>องค์กรในระบบ</a>
			</li>
		@endif
	</ul>
</div>

Summary: NethServer bandwidth usage
Name: nethserver-bandwidthd
Version: 1.0.0
Release: 1%{?dist}
License: GPL
Source: %{name}-%{version}.tar.gz
BuildArch: noarch
URL: https://github.com/NethServer/%{name}

BuildRequires: nethserver-devtools
Requires: php-pdo, php-gd, sqlite
Requires: nethserver-httpd
Requires: bandwidthd

%description
NethServer bandwidth usage

%prep
%setup

%build
%{makedocs}
perl createlinks

%install
rm -rf %{buildroot}
(cd root   ; find . -depth -not -name '*.orig' -print  | cpio -dump %{buildroot})
mkdir -p %{buildroot}/%{getmail_home}
%{genfilelist} %{buildroot} > %{name}-%{version}-%{release}-filelist

%files -f %{name}-%{version}-%{release}-filelist
%defattr(-,root,root)
%dir %{_nseventsdir}/%{name}-update
%doc COPYING

%changelog
* Fri Aug 05 2016 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.0-1
- First release - NethServer/dev#5077


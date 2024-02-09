#include<iostream.h>
#include<conio.h>
class person
{
protected:
char name[10],address[10];
long int ph_no;
public:
void read()
{
cout<<"\n Enter the Name, Address,Phone number \n ";
cin>>name>>address>>ph_no;
}
};
class employee : public person
{
protected:
int emp_no;
public:
void read();
void get()
{
cout<<"\n Enter the Employee No.  :";
cin>>emp_no;
}
};
class manager : employee
{
char desig[10],dept_name[10];
float bpay;
public:
void getdata()
{
void read();
void get();
cout<<"\n";
cout<<"\n Enter Department Name , Designation, Basic Salary \n";
cin>>dept_name>>desig>>bpay;
}
void display()
{
cout<<"\n Name :"<<name;
cout<<"\n Address :"<<address;
cout<<"\n Phone Number :"<<ph_no;
cout<<"\n Employee Number :"<<emp_no;
cout<<"\n Department :"<<dept_name;
cout<<"\n Designation :"<<desig;
cout<<"\n Basic Salary :"<<bpay;
}
};
int main()
{
int i, n;
clrscr();
manager M[20];
cout<<"\n Enter the no.of managers :";
cin>>n;
for(i=0;i<n;i++)
M[i].getdata();
for(i=0;i<n;i++)
M[i].display();
getch();
return 0;
}
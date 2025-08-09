def check_fermat(a,b,c,n):
	if n>2 and (a**n + b**n==c**n):
		print("White smokes, Fermat was wrong! ")
	else:
		print("No, that doesn't work")


def test_integers():
 a=int(input("Enter the value of a: "))
 b=int(input("Enter the value of b: "))
 c=int(input("Enter the value of c: "))
 d=int(input("Enter the value of d: "))
 return check_fermat(a,b,c,n)

test_integers()8
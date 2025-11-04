import sys

print("fu")
print(sys.argv[1])
with open("otus.txt", "w") as file:
    file.write(sys.argv[1])
